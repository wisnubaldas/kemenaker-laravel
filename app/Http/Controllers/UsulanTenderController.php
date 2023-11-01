<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewDraftUsulanRequest;
use App\Models\TaGroup;
use App\Models\TaUsulanTender;
use App\Models\ThAnggotaPokja;
use App\Models\ThUsulanTender;
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
                    ->join('th_usulan_tender_pokja', function ($join) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', 55);
                    });
                break;
            case 2:
                $detailusulanlist
                    ->where('th_usulan_tender.tmunitkerja_id', $user->tmunitkerja_id)
                    ->where('th_usulan_tender.created_by', $user->id);
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

        //dd($data['data']);
        return view('app.usulantender', $data);
    }
    public function detail(Request $request, $usulan_tender_detail_id): View
    {
        $detailusulanlist = (new ThUsulanTenderDetail())->getCompleteData();
        $data = [
            "title" => "Usulan Tender",
            "data" => $detailusulanlist->where('th_usulan_tender_detail.id', $usulan_tender_detail_id)->first()
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
                            $model_doc = new ThUsulanTenderDetailDoc();
                            $model_doc->thusulantenderdetail_id = $model_detail->id;
                            $model_doc->nama_berkas = $doc["nama_berkas"];
                            $file = $doc['berkas'];
                            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
                            $file->storeAs('berkas', $uniqueFileName, 'public');
                            $model_doc->berkas = $uniqueFileName;
                            $model_doc->save();
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
            $usulanTenderDetails = $request->input('usulanTenderDetails');
            // dd($usulanTenderDetails);
            foreach ($usulanTenderDetails as $index => $detail) {
                if (isset($detail['id'])) {
                    $model_detail = ThUsulanTenderDetail::find($detail['id']);
                    $namaTender = $detail['nama_tender'];
                    $tmjenistender_id = $detail['tmjenistender_id'];
                    $model_detail->nama_tender = $namaTender;
                    $model_detail->tmjenistender_id = $tmjenistender_id;
                    $model_detail->save();
                } else {
                    $model_detail = $this->savenewdetail($detail, $model->id);
                }
                $docs = request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'];

                foreach ($docs as $i => $doc) {
                    if (isset($doc['id'])) {
                        $model_doc = ThUsulanTenderDetailDoc::where('berkas', $doc['id'])->first();
                        //$model_doc = clone $ori_model_doc; 
                        //$model_doc= ThUsulanTenderDetailDoc::where('berkas',$doc['id'])->first();
                        $model_doc->nama_berkas = $doc["nama_berkas"];
                        if (isset($doc['berkas'])) {
                            $file = $doc['berkas'];
                            if (Storage::disk('public')->exists($file)) {
                                Storage::disk('public')->delete($model->file_surat_usulan);
                            }
                            if (Storage::disk('public')->exists('berkas/' . $model_doc->berkas)) {
                                Storage::disk('public')->delete('berkas/' . $model_doc->berkas);
                            }
                            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
                            $file->storeAs('berkas', $uniqueFileName, 'public');
                            $model_doc->berkas = $uniqueFileName;
                        }
                        $model_doc->save();
                        // dd($model_doc,$doc);
                    }
                }
            }
            $members = $request->input('pokja');
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
                    $nip = $member['nip'];
                    $ceknip = ThAnggotaPokja::where('nip', $nip)->first();
                    if ($ceknip) {
                        $registeredpokja++;
                    } else {
                        $modelPokja = ThUsulanTenderUsulpokja::find($member['id']);
                     
                        $modelPokja=$this->saveMember($modelPokja, $nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                       
                        // dd($modelPokja);
                    }
                }
            }
            DB::commit();
            return redirect()->route('draft-usulan-tender')->with(
                'success',
                'Draft usulan berhasil diperbaharui'
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
}
