<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewDraftUsulanRequest;
use App\Http\Requests\STRequest;
use App\Models\TaGroup;
use App\Models\TaUsulanTender;
use App\Models\ThAnggotaPokja;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderAlur;
use App\Models\ThUsulanTenderDetail;
use App\Models\ThUsulanTenderDetailDoc;
use App\Models\ThUsulanTenderPokja;
use App\Models\ThUsulanTenderUsulpokja;
use App\Models\TmJenisTender;
use App\Models\TmUnitkerja;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;

class UsulanTenderController extends Controller
{
    public function index(Request $request): View
    {
        $detailusulanlist = (new ThUsulanTenderDetail())->getCompleteData();
        $user = Auth::user();
        $role = $user->tagroup_id;
        switch ($role) {
            case 1:
                $detailusulanlist
                    ->join('th_usulan_tender_pokja', function ($join) use ($user) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', $user->thanggotapokja_id);
                    });
                break;
            case 2:
                $detailusulanlist
                    ->where('th_usulan_tender.tmunitkerja_id', $user->tmunitkerja_id)
                    ->where('th_usulan_tender.created_by', $user->id);
                break;
            case 5:
                $detailusulanlist
                    ->join('th_usulan_tender_pokja', function ($join) use ($user) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', $user->thanggotapokja_id);
                    });
                break;
        }
        $data = [
            "title" => "Usulan Tender",
            "data" =>
            $detailusulanlist
                ->when($request->input('tm_unitkerja_id'), function ($query, $tm_unitkerja_id) {
                    return $query->where('th_usulan_tender.tmunitkerja_id', $tm_unitkerja_id);
                })
                ->when($request->input('no_surat_usulan'), function ($query, $no_surat_usulan) {
                    return $query->where('th_usulan_tender.no_surat_usulan', 'like', '%' . $no_surat_usulan . '%');
                })
                ->when($request->input('nama_tender'), function ($query, $nama_tender) {
                    return $query->where('th_usulan_tender_detail.nama_tender', 'like', '%' . $nama_tender . '%');
                })
                ->orderBy('th_usulan_tender_detail.updated_date', 'DESC')
                ->paginate(20),
            "tm_unitkerja" => (new TmUnitkerja())->getSortedUnitKerja()

        ];

        // dd($data['data']);
        return view('app.usulantender', $data);
    }
    public function detail(Request $request, $usulan_tender_detail_id): View
    {
        $detailusulanlist = ThUsulanTenderDetail::with(['usulanTender', 'usulanTender.usulanTenderUsulPokja', 'tmJenisTender', 'usulanTenderDetailDoc', 'usulanTenderPokja'])->find($usulan_tender_detail_id);
        //dd($detailusulanlist);
        $anggota = ThAnggotaPokja::select('id', DB::raw('nip || \' / \' || nama_lengkap || \' / \' || jabatan || \' \' || unit_kerja as nama_lengkap'))
            ->where('status', 1)
            ->orderBy('id')
            ->get();
        $data = [
            "title" => "Usulan Tender",
            "data" => $detailusulanlist,
            "anggotas" => $anggota
        ];
        return view('app.usulantenderdetail', $data);
    }
    public function submit_newdraft(NewDraftUsulanRequest $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $errTenderDetCount = 0;
            $errDocCount = 0;
            $errMemberCount = 0;
            $registeredpokja = 0;
            $model = $this->savenewtender($request);
            $usulanTenderDetails = $request->input('usulanTenderDetails');
            foreach ($usulanTenderDetails as $index => $detail) {
                $validator = Validator::make($detail, [
                    'nama_tender' => 'required',
                    'tmjenistender_id' => 'required'
                ]);
                // dd(request()->all());
                if ($validator->fails()) {
                    $errTenderDetCount++;
                } else {
                    $model_detail = $this->savenewdetail($detail, $model->id);
                    $docs = request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'];
                    foreach ($docs as $i => $doc) {

                        $membervalidator = Validator::make($doc, [
                            'nama_berkas' => 'nullable',
                            'berkas' => 'required|file|mimes:pdf|max:25000',
                        ]);
                        // dd(request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'][$i]['berkas']);      
                        if (!$membervalidator->fails()) {
                            $this->savedoc($model_detail->id, $doc);
                        } else {
                            $errDocCount++;
                        }
                    }
                }
            }
            $members = $request->input('pokja');
            foreach ($members as $member) {
                $membervalidator = Validator::make($member, [
                    'nip' => 'required:max:20',
                    'nama_lengkap' => 'nullable|max:100',
                    'jabatan' => 'nullable|max:50',
                    'keterangan' => 'nullable|max:250',
                ]);
                if ($membervalidator->fails()) {
                    $errMemberCount++;
                } else {
                    $nip = $member['nip'];
                    $ceknip = ThAnggotaPokja::where('nip', $nip)->first();
                    if ($ceknip) {
                        $registeredpokja++;
                    } else {
                        $modelPokja = new ThUsulanTenderUsulpokja();
                        $this->saveMember($modelPokja, $nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                    }
                }
            }

            //dd($members);

            DB::commit();
            return redirect()->route('draft-usulan-tender')
                ->with(
                    'success',
                    'Usulan berhasil disimpan. '
                        . $errTenderDetCount . ' Tender Gagal Tersimpan dan '
                        . $errDocCount . ' Dokumen Gagal Tersimpan dan '
                        . $errMemberCount . ' Anggota Gagal Tersimpan dan '
                        . $registeredpokja . ' Usulan Anggota Pokja Sudah ada dalam database'
                );
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('new-usulan-tender')->withInput();
        }
    }

    public function newdraft(Request $request): View
    {
        $detailusulanlist = (new ThUsulanTenderDetail())->getCompleteData();
        $data = [
            "title" => "Usulan Tender",
            "jenis_tender" => TmJenisTender::orderby('jenis_tender')->get(),
            "is_edit" => false,
            "data" => [
                "usulan_tender_details" => [
                    [
                        "usulan_tender_detail_doc" => [
                            [
                                "nama_berkas" => ""
                            ]
                        ]
                    ]
                ],
                "usulan_tender_usul_pokja" => [
                    [
                        "nip" => ""
                    ]
                ]
            ]
        ];
        return view('app.formusulantender', $data);
    }
    public function editdraft(Request $request, $tender_id): View
    {
        $data = ThUsulanTender::with('usulanTenderDetails.usulanTenderDetailDoc', 'usulanTenderUsulPokja')
            ->where('id', $tender_id)
            ->first();
        $data = [
            "title" => "Usulan Tender",
            "jenis_tender" => TmJenisTender::orderby('jenis_tender')->get(),
            "is_edit" => true,
            "data" => $data
        ];
        return view('app.formusulantender', $data);
    }
    private function savedoc($detail_id, $doc)
    {
        $model_doc = new ThUsulanTenderDetailDoc();
        $model_doc->thusulantenderdetail_id = $detail_id;
        $model_doc->nama_berkas = $doc["nama_berkas"];
        $file = $doc['berkas'];
        $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
        $file->storeAs('berkas', $uniqueFileName, 'public');
        $model_doc->berkas = $uniqueFileName;
        $model_doc->save();
        return $model_doc;
    }
    private function saveMember($modelPokja, $nip, $nama_lengkap, $jabatan, $keterangan, $tender_id)
    {

        $modelPokja->nip = $nip;
        $modelPokja->nama_lengkap = $nama_lengkap;
        $modelPokja->jabatan = $jabatan;
        $modelPokja->keterangan = $keterangan;
        $modelPokja->thusulantender_id = $tender_id;
        $modelPokja->save();
        return $modelPokja;
    }
    public function send($id)
    {
        DB::beginTransaction();
        try {
            $model = ThUsulanTender::find($id);
            $alurlama = $model->alur;
            $posisilama = $model->posisi;
            $model->posisi = 3;
            $model->alur = '0';
            $user = Auth::user();
            if ($alurlama == "" && $posisilama == "" && $user->tagroup_id == 2) {
                if ($model->save()) {
                    $model_detail = ThUsulanTenderDetail::where('thusulantender_id', $model->id)->get();
                    foreach ($model_detail as $detail) {
                        $detail->alur = '0';
                        $detail->posisi = 3;
                        $detail->save();
                        $alur = new ThUsulanTenderAlur();
                        $alur->thusulantenderdetail_id = $detail->id;
                        $alur->tagroup_id = $user->tagroup_id;
                        $alur->alur = '0';
                        $alur->posisi = 3;
                        $alur->save();
                    }

                    $model_usulpokja = ThUsulanTenderUsulpokja::where('thusulantender_id', $model->id)->get();
                    foreach ($model_usulpokja as $pokja) {
                        $anggota = ThAnggotaPokja::firstOrCreate(
                            ['nip' => $pokja->nip],
                            [
                                'nama_lengkap' => $pokja->nama_lengkap,
                                'jabatan' => $pokja->jabatan,
                                'unit_kerja' => $pokja->unit_kerja,
                                'tmunitkerja_id' => $pokja->tmunitkerja_id,
                                'status' => 0,
                            ]
                        );
                    }
                }
            }
            DB::commit();
            return $model;
        } catch (Exception $e) {
            //dd($e);
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    private function savenewdetail($detail, $tender_id)
    {
        $namaTender = $detail['nama_tender'];
        $tmjenistender_id = $detail['tmjenistender_id'];
        $model_detail = new ThUsulanTenderDetail();
        $model_detail->nama_tender = $namaTender;
        $model_detail->thusulantender_id = $tender_id;
        $model_detail->tmjenistender_id = $tmjenistender_id;
        $model_detail->save();
        return $model_detail;
    }
    private function savenewtender(Request $request)
    {
        $model = new ThUsulanTender();
        $model->no_surat_usulan = $request->input('no_surat_usulan');
        $model->keterangan = $request->input('keterangan');
        if ($request->hasFile('file_surat_usulan')) {
            $file = $request->file('file_surat_usulan');
            //   dd($file);
            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
            $file->storeAs('surat_usulan', $uniqueFileName, 'public');
            $model->file_surat_usulan = $uniqueFileName;
        }
        $model->save();
        return $model;
    }
    public function updatedraft(Request $request, $tender_id): RedirectResponse
    {
        $registeredpokja = 0;
        $errMemberCount = 0;
        $errDocCount = 0;
        $errTenderDetCount = 0;
        DB::beginTransaction();
        try {
            $model = ThUsulanTender::find($tender_id);
            $model->no_surat_usulan = request('no_surat_usulan');
            $model->keterangan = request('keterangan');

            if ($request->hasFile('file_surat_usulan')) {
                $file = $request->file('file_surat_usulan');
                $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
                $file->storeAs('surat_usulan', $uniqueFileName, 'public');
                if (Storage::disk('public')->exists('surat_usulan/' . $model->file_surat_usulan)) {
                    Storage::disk('public')->delete('surat_usulan/' . $model->file_surat_usulan);
                }
                $model->file_surat_usulan = $uniqueFileName;
            }
            $model->save();
            $usulanTenderDetails = $request->input('usulanTenderDetails') ?? [];
            foreach ($usulanTenderDetails as $index => $detail) {
                if (isset($detail['id'])) {
                    $model_detail = ThUsulanTenderDetail::find($detail['id']);
                    if (isset($detail['is_del']) && $detail['is_del']) {
                        $model_detail->delete();
                        ThUsulanTenderDetailDoc::where('thusulantenderdetail_id', $detail['id'])->get()->each(function ($doc) {
                            Storage::disk('public')->delete('berkas/' . $doc->berkas);
                            $doc->delete();
                        });
                        continue;
                    } else {
                        $namaTender = $detail['nama_tender'];
                        $tmjenistender_id = $detail['tmjenistender_id'];
                        $model_detail->nama_tender = $namaTender;
                        $model_detail->tmjenistender_id = $tmjenistender_id;
                        $model_detail->save();
                    }
                } else {
                    $validator = Validator::make($detail, [
                        'nama_tender' => 'required',
                        'tmjenistender_id' => 'required'
                    ]);
                    // dd(request()->all());
                    if ($validator->fails()) {
                        $errTenderDetCount++;
                    } else {
                        $model_detail = $this->savenewdetail($detail, $model->id);
                    }
                }
                $docs = request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'] ?? [];

                foreach ($docs as $i => $doc) {
                    if (isset($doc['id'])) {
                        $model_doc = ThUsulanTenderDetailDoc::where('berkas', $doc['id'])->first();
                        if (isset($doc['is_del']) && $doc['is_del']) {
                            $model_doc->delete();
                            if (Storage::disk('public')->exists('berkas/' . $model_doc->berkas)) {
                                Storage::disk('public')->delete('berkas/' . $model_doc->berkas);
                            }
                            continue;
                        }
                        $model_doc->nama_berkas = $doc["nama_berkas"];
                        if (isset($doc['berkas'])) {
                            $file = $doc['berkas'];

                            if (Storage::disk('public')->exists('berkas/' . $model_doc->berkas)) {
                                Storage::disk('public')->delete('berkas/' . $model_doc->berkas);
                            }
                            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
                            $file->storeAs('berkas', $uniqueFileName, 'public');
                            $model_doc->berkas = $uniqueFileName;
                        }
                        $model_doc->save();
                        // dd($model_doc,$doc);
                    } else {

                        $membervalidator = Validator::make($doc, [
                            'nama_berkas' => 'nullable',
                            'berkas' => 'required|file|mimes:pdf|max:25000',
                        ]);
                        // dd(request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'][$i]['berkas']);      
                        if (!$membervalidator->fails()) {
                            $this->savedoc($model_detail->id, $doc);
                        } else {
                            $errDocCount++;
                        }
                    }
                }
            }
            $members = $request->input('pokja') ?? [];
            //dd($members);
            foreach ($members as $member) {
                if (!isset($member['id'])) {
                    $membervalidator = Validator::make($member, [
                        'nip' => 'required:max:20',
                        'nama_lengkap' => 'nullable|max:100',
                        'jabatan' => 'nullable|max:50',
                        'keterangan' => 'nullable|max:250',
                    ]);
                    if ($membervalidator->fails()) {
                        $errMemberCount++;
                    } else {
                        $nip = $member['nip'];
                        $ceknip = ThAnggotaPokja::where('nip', $nip)->first();
                        if ($ceknip) {
                            $registeredpokja++;
                        } else {
                            $modelPokja = new ThUsulanTenderUsulpokja();
                            $this->saveMember($modelPokja, $nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                        }
                    }
                } else {
                    $modelPokja = ThUsulanTenderUsulpokja::find($member['id']);
                    if (isset($member['is_del']) && $member['is_del']) {
                        $modelPokja->delete();
                        continue;
                    }
                    $nip = $member['nip'];
                    $ceknip = ThAnggotaPokja::where('nip', $nip)->first();
                    if ($ceknip) {
                        $registeredpokja++;
                    } else {
                        $modelPokja = $this->saveMember($modelPokja, $nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);

                        // dd($modelPokja);
                    }
                }
            }
            DB::commit();
            return redirect()->route('draft-usulan-tender')
                ->with(
                    'success',
                    'Usulan berhasil diperbarui. '
                        . $errTenderDetCount . ' Tender Gagal Tersimpan dan '
                        . $errDocCount . ' Dokumen Gagal Tersimpan dan '
                        . $errMemberCount . ' Anggota Gagal Tersimpan dan '
                        . $registeredpokja . ' Usulan Anggota Pokja Sudah ada dalam database'
                );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
    public function draftlist(Request $request): View
    {

        // dd($request->all());

        $user = Auth::user();
        $role = $user->tagroup_id;
        $detailusulanlist = (new ThUsulanTender())->getdraft($user->tmunitkerja_id, $user->id);
        //dd($detailusulanlist);
        $data = [
            "title" => "Usulan Tender",
            "data" => $detailusulanlist
                ->orderByDesc('th_usulan_tender.created_date')
                ->paginate(20),
            "tm_unitkerja" => (new TmUnitkerja())->getSortedUnitKerja()

        ];

        //dd($data['data']);
        return view('app.draftusulantender', $data);
    }
    public function verifikasi(Request $request, $usulan_tender_detail_id)
    {
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $model = ThUsulanTender::find($model_detail->thusulantender_id);
        $model_alur = new ThUsulanTenderAlur();
    }
    private function isApprove(Request $request, $usulan_tender_detail_id, $is_approve)
    {
        $user = Auth::user();
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $model = ThUsulanTender::find($model_detail->thusulantender_id);
        if ($is_approve) {
            if ($model_detail->alur == 7) {
                $alur = '9';
                $posisi = null;
                $tender_posisi = '2';
            } 
            elseif($model_detail->alur == 13){
                $alur = '16';
                $posisi = null;
                $tender_posisi = '3';
            }
            else {
                $alur = '3';
                $posisi = '4';
                $tender_posisi = '4';
            }
        } else {
            if ($model_detail->alur == 7) {
                $alur = '8';
                $posisi = null;
                $tender_posisi = '5';
            }
            elseif($model_detail->alur == 13){
                $alur = '14';
                $posisi = '5';
                $tender_posisi = '5';
            } else {
                $alur = '2';
                $posisi = '2';
                $tender_posisi = '2';
            }
        }

        $model_detail->alur = $alur;
        $model_detail->posisi = $tender_posisi;
        $model_detail->catatan = request('catatan');
        $model_detail->save();

        $this->savealur($alur, $posisi, $usulan_tender_detail_id);
    }
    public function approvetender(Request $request, $usulan_tender_detail_id)
    {
        $this->isApprove($request, $usulan_tender_detail_id, true);
    }
    public function rejecttender(Request $request, $usulan_tender_detail_id)
    {
        $this->isApprove($request, $usulan_tender_detail_id, false);
    }
    private function savealur($alur, $posisi, $detail_id)
    {
        $user = Auth::user();
        $model_alur = new ThUsulanTenderAlur();
        $model_alur->thusulantenderdetail_id = $detail_id;
        $model_alur->tagroup_id = $user->tagroup_id;
        $model_alur->alur = $alur; //perlu riset lagi
        $model_alur->keterangan = request('catatan');
        $model_alur->posisi = $posisi;
        $model_alur->save();
        return $model_alur;
    }
    public function submit_ba_pemilihan(Request $request, $usulan_tender_detail_id): RedirectResponse
    {
        DB::beginTransaction();
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $validated = $request->validate([
            'ba_hasil_pemilihan' => 'required|file|mimes:pdf|max:25000',
        ], [
            'ba_hasil_pemilihan.required' => "Ba kaji ulang tidak boleh kosong",
            'ba_hasil_pemilihan.file' => "Data harus berupa file",
            'ba_kajba_hasil_pemilihani_ulang.mimes' => 'File harus berpa pdf',
            'ba_hasil_pemilihan.max' => 'File tidak boleh leboh dari 25Mb'
        ]);
        try {
            $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
            if ($request->hasFile('ba_hasil_pemilihan')) {
                $file = $request->file('ba_hasil_pemilihan');
                //   dd($file);
                $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
                $file->storeAs('ba_hasil', $uniqueFileName, 'public');
                $model_detail->ba_hasil_pemilihan = $uniqueFileName;
            } else {
                throw new Exception("File Not Found");
            }

            $this->savealur(13, 2, $usulan_tender_detail_id);
            $model_detail->alur = 13;
            $model_detail->posisi = 2;
            $model_detail->save();
            DB::commit();   
            return redirect()->route('usulan-tender')->with(
                'success',
                'Unggah BA Hasil Pemilihan Berhasil.'
            );;
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function submit_ba(Request $request, $usulan_tender_detail_id): RedirectResponse
    {
        DB::beginTransaction();
        //dd(request()->all());
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $validated = $request->validate([
            'ba_kaji_ulang' => 'required|file|mimes:pdf|max:25000',
        ], [
            'ba_kaji_ulang.required' => "Ba kaji ulang tidak boleh kosong",
            'ba_kaji_ulanng.file' => "Data harus berupa file",
            'ba_kaji_ulang.mimes' => 'File harus berpa pdf',
            'ba_kaji_ulang.max' => 'File tidak boleh leboh dari 25Mb'
        ]);
        try {
            $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
            if ($request->hasFile('ba_kaji_ulang')) {
                $file = $request->file('ba_kaji_ulang');
                //   dd($file);
                $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
                $file->storeAs('ba_kaji', $uniqueFileName, 'public');
                $model_detail->ba_kaji_ulang = $uniqueFileName;
            } else {
                throw new Exception("File Not Found");
            }

            $this->savealur(7, 3, $usulan_tender_detail_id);
            $model_detail->alur = 7;
            $model_detail->posisi = 3;
            $model_detail->save();
            DB::commit();
            return redirect()->route('usulan-tender')->with(
                'success',
                'Berhasil unggah surat Berita Acara.'
            );;
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function submit_st(STRequest $request, $usulan_tender_detail_id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $data = request()->all();

            $user = Auth::user();
            $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
            $model = ThUsulanTender::find($model_detail->thusulantender_id);

            $model_detail->nomor_st = request('nomor_st');
            $model_detail->tgl_st = request('tgl_st');
            //dd($request->hasFile('surat_st'));
            if ($request->hasFile('surat_st')) {
                $file = $request->file('surat_st');
                //   dd($file);
                $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
                $file->storeAs('surat_st', $uniqueFileName, 'public');
                $model_detail->surat_st = $uniqueFileName;
            }
            $model_detail->save();
            //dd($data);
            $jmlpokja = 0;

            foreach ($data['anggota'] as $anggota) {
                $anggotanya = ThAnggotaPokja::find($anggota);
                if (!$anggotanya) {
                    dd($anggota);
                }
                $pokja = new ThUsulanTenderPokja();
                $pokja->nip = $anggotanya->nip;
                $pokja->jabatan = $anggotanya->jabatan;
                $pokja->unit_kerja = $anggotanya->unit_kerja;
                $pokja->nama_lengkap = $anggotanya->nama_lengkap;
                $pokja->thusulananggotapokja_id = $anggotanya->id;
                $pokja->thusulantenderdetail_id = $usulan_tender_detail_id;
                $pokja->tmunitkerja_id = $anggotanya->tmunitkerja_id;
                $pokja->save();
            }
            $this->savealur(6, 5, $usulan_tender_detail_id);
            $model_detail->alur = 6;
            $model_detail->posisi = 5;
            $model_detail->save();
            DB::commit();
            return redirect()->route('usulan-tender')->with(
                'success',
                'Berhasil Update Nomor Surat Tugas.'
            );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
    public function updatelpse(Request $request, $usulan_tender_detail_id): RedirectResponse
    {

        DB::beginTransaction();
        $validated = $request->validate([
            'kode_tender' => 'required',
            'kode_rup' => 'required',
        ], [
            'kode_tender.required' => "Kode tender tidak boleh kosong",
            'kode_rup.required' => "Kode RUP tidak boleh kosong",
        ]);
        try {

            $data = request()->all();
            $user = Auth::user();
            $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
            $model_detail->kode_tender = request('kode_tender');
            $model_detail->kode_rup = request('kode_rup');
            $model_detail->alur = 10;
            $model_detail->posisi = 4;
            $model_detail->save();
            $this->savealur(10, 4, $usulan_tender_detail_id);
            DB::commit();
            return redirect()->route('usulan-tender')->with(
                'success',
                'Berhasil Paket LPSE telah dibuat oleh PPK.'
            );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
    public function submit_delegate(Request $request, $usulan_tender_detail_id): RedirectResponse
    {

      //  dd(request()->all());
        DB::beginTransaction();
       
        try {
            if (request('delegasi') == 'YES') {
                $data = request()->all();
                $user = Auth::user();
                $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
                $model_detail->alur = 11;
                $model_detail->posisi = 3;
                $model_detail->save();
                $this->savealur(11, 3, $usulan_tender_detail_id);
                DB::commit();
            }
            return redirect()->route('usulan-tender')->with(
                'success',
                'Berhasil mem-verifikasi untuk mendelegasikan paket ke pokja.'
            );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
    public function deploy_lpse(Request $request, $usulan_tender_detail_id): RedirectResponse
    {

      //  dd(request()->all());
        DB::beginTransaction();
       
        try {
            if (request('delegasi') == 'YES') {
                $data = request()->all();
                $user = Auth::user();
                $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
                $model_detail->alur = 12;
                $model_detail->posisi = 5;
                $model_detail->save();
                $this->savealur(12, 5, $usulan_tender_detail_id);
                DB::commit();
            }
            return redirect()->route('usulan-tender')->with(
                'success',
                'Berhasil mem-verifikasi penayangan LPSE.'
            );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
    public function submit_sph(Request $request, $usulan_tender_detail_id): RedirectResponse
    {
        DB::beginTransaction();
        if(request('approve')){
            $validated = $request->validate([
                'file_lap_hpk' => 'required',
                'file_spk' => 'required',
            ], [
                'file_lap_hpk.required' => "Hasil Penandatanganan Kontrak tidak boleh kosong",
                'file_lap_hpk.file' => "Data harus berupa file",
                'file_lap_hpk.mimes' => 'File harus berpa pdf',
                'file_lap_hpk.max' => 'File tidak boleh leboh dari 25Mb',
                'file_spk.required' => "Surat Perjanjian Kontrak tidak boleh kosong",
                'file_spk.file' => "Data harus berupa file",
                'file_spk.mimes' => 'File harus berpa pdf',
                'file_spk.max' => 'File tidak boleh leboh dari 25Mb'
            ]);
        }
        try {
            if(!request('approve')){
                $this->isApprove($request,$usulan_tender_detail_id,false);
            }else{
                $data = request()->all();
                $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
                if ($request->hasFile('file_lap_hpk')) {
                    $file = $request->file('file_lap_hpk');
                    $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
                    $file->storeAs('_upload', $uniqueFileName, 'public');
                    $model_detail->file_lap_hpk = $uniqueFileName;
                }
                if ($request->hasFile('file_spk')) {
                    $file = $request->file('file_spk');
                    $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
                    $file->storeAs('_upload', $uniqueFileName, 'public');
                    $model_detail->file_spk = $uniqueFileName;
                }
                $model_detail->save();
                $this->isApprove($request,$usulan_tender_detail_id,true);
            }
            DB::commit();
            return redirect()->route('usulan-tender')->with(
                'success',
                'Berhasil mengirimkan Laporan hasil penandatanganan kontrak beserta SPK ke Sekretariat'
            );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
}
