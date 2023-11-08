<?php

namespace App\Services;

use App\Http\Requests\NewDraftUsulanRequest;
use App\Models\ThAnggotaPokja;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Models\ThUsulanTenderDetailDoc;
use App\Models\ThUsulanTenderUsulpokja;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ThUsulanTenderService
{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTender());
    }
    public function savenewtender(Request $request)
    {
        $model = $this->model;
        $model->no_surat_usulan = $request->input('no_surat_usulan');
        $model->keterangan = $request->input('keterangan');
        $model->tipe_tender = request('tipe_tender');
        if ($request->hasFile('file_surat_usulan')) {
            $file = $request->file('file_surat_usulan');
            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
            $file->storeAs('surat_usulan', $uniqueFileName, 'public');
            $model->file_surat_usulan = $uniqueFileName;
        }
        $model->save();
        return $model;
    }
    public function updatetender(Request $request, $tender_id)
    {
        $model = ThUsulanTender::find($tender_id);
        $model->no_surat_usulan = request('no_surat_usulan');
        $model->keterangan = request('keterangan');

        if ($request->hasFile('file_surat_usulan')) {
            $file = $request->file('file_surat_usulan');
            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
            $file->storeAs('_upload', $uniqueFileName, 'public');
            if (Storage::disk('public')->exists('_upload/' . $model->file_surat_usulan)) {
                Storage::disk('public')->delete('_upload/' . $model->file_surat_usulan);
            }
            $model->file_surat_usulan = $uniqueFileName;
        }
        $model->save();
        return $model;
    }
    public function submit_service(NewDraftUsulanRequest $request)
    {
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
            if ($validator->fails()) {
                $errTenderDetCount++;
            } else {
                $detailService = new ThUsulanTenderDetailService();
                $model_detail = $detailService->savenewdetail($detail, $model->id);
                $docs = request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'];
                foreach ($docs as $i => $doc) {

                    $docsValidator = Validator::make($doc, [
                        //     'nama_berkas' => 'required',
                        'berkas' => 'nullable|file|mimes:pdf|max:25000',
                        'tmjenistenderdoc_id' => 'required'
                    ]);
                    // dd($docsValidator->fails());
                    if (!$docsValidator->fails()) {

                        $detailDocService = new ThUsulanTenderDetailDocService();
                        $detailDocService->savedoc($model_detail->id, $doc);
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
                    $servicePokja = new ThUsulanTenderUsulpokjaService();
                    $servicePokja->newMember($nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                }
            }
        }
        return  'Usulan berhasil disimpan. '
            . $errTenderDetCount . ' Tender Gagal Tersimpan dan '
            . $errDocCount . ' Dokumen Gagal Tersimpan dan '
            . $errMemberCount . ' Anggota Gagal Tersimpan dan '
            . $registeredpokja . ' Usulan Anggota Pokja Sudah ada dalam database';
    }
    public function update_service($request,$tender_id){
        $registeredpokja = 0;
        $errMemberCount = 0;
        $errDocCount = 0;
        $errTenderDetCount = 0;
        DB::beginTransaction();
            $model = (new ThUsulanTenderService())->updatetender($request, $tender_id);
            $usulanTenderDetails = $request->input('usulanTenderDetails') ?? [];
            foreach ($usulanTenderDetails as $index => $detail) {
                if (isset($detail['id'])) {
                    $model_detail = ThUsulanTenderDetail::find($detail['id']);
                    if (isset($detail['is_del']) && $detail['is_del']) {
                        $model_detail->delete();
                        ThUsulanTenderDetailDoc::where('thusulantenderdetail_id', $detail['id'])->get()->each(function ($doc) {
                            Storage::disk('public')->delete('_upload/' . $doc->berkas);
                            $doc->delete();
                        });
                        continue;
                    } else {
                        $namaTender = $detail['nama_tender'];
                        $model_detail->nama_tender = $namaTender;
                        $model_detail->save();
                    }
                } else {
                    $validator = Validator::make($detail, [
                        'nama_tender' => 'required',
                        'tmjenistender_id' => 'required'
                    ]);
                    if ($validator->fails()) {
                        $errTenderDetCount++;
                    } else {
                        $model_detail = (new ThUsulanTenderDetailService())->savenewdetail($detail, $model->id);

                    }
                    $docs = request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'] ?? [];

                foreach ($docs as $i => $doc) {
                    if (!isset($doc['id'])) {
                        $docsValidator = Validator::make($doc, [
                            'berkas' => 'nullable|file|mimes:pdf|max:25000',
                            'tmjenistenderdoc_id' => 'required'
                        ]);
                        if (!$docsValidator->fails()) {
                            $detailDocService = new ThUsulanTenderDetailDocService();
                            $detailDocService->savedoc($model_detail->id, $doc);
                        } else {
                            $errDocCount++;
                        }
                    }
                }
                }
            }
            $members = $request->input('pokja') ?? [];
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
                            $servicePokja = new ThUsulanTenderUsulpokjaService();
                            $modelPokja = $servicePokja->newMember($nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                        }
                    }
                } else {
                    if (isset($member['is_del']) && $member['is_del']) {
                        ThUsulanTenderUsulpokja::find($member['id'])->delete();
                        continue;
                    }
                    $nip = $member['nip'];
                    $ceknip = ThAnggotaPokja::where('nip', $nip)->first();
                    if ($ceknip) {
                        $registeredpokja++;
                    } else {
                        $servicePokja = new ThUsulanTenderUsulpokjaService();
                        $modelPokja = $servicePokja->updMember($member['id'], $nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                    }
                }
            }
        return 'Usulan berhasil diperbarui. '
        . $errTenderDetCount . ' Tender Gagal Tersimpan dan '
        . $errDocCount . ' Dokumen Gagal Tersimpan dan '
        . $errMemberCount . ' Anggota Gagal Tersimpan dan '
        . $registeredpokja . ' Usulan Anggota Pokja Sudah ada dalam database';
    }
    private function cekcomplete($id){
        $model=$this->model->find($id);
        if(!$model->file_surat_usulan){
            throw new Exception("File Surat Usulan Belum Di Upload");
        }
        $details=ThUsulanTenderDetail::where('thusulantender_id',$id)->get();
        if(count($details)<1){
            throw new Exception("Belum ada tender yang di buat");
        }else{
            foreach($details as $detail){
                $docs=ThUsulanTenderDetailDoc::where('thusulantenderdetail_id',$detail->id)->get();
                if(count($docs)<1){
                    throw new Exception("Belum ada dokumen tender yang di buat");
                }else{
                    foreach($docs as $doc){
                        if(!$doc->berkas){
                            throw new Exception("Ada dokumen tender yang belum diunggah");
                        }
                    }
                }
            }
        }
        

    }
    public function send($id){
        $model = ThUsulanTender::find($id);
            $alurlama = $model->alur;
            $posisilama = $model->posisi;
            $model->posisi = 3;
            $model->alur = '0';
            $user = Auth::user();
            $this->cekcomplete($id);
            if ($alurlama == "" && $posisilama == "" && $user->tagroup_id == 2) {
                if ($model->save()) {
                    $model_detail = ThUsulanTenderDetail::where('thusulantender_id', $model->id)->get();
                    foreach ($model_detail as $detail) {
                        $alur=new ThUsulanTenderDetailService();
                       
                        $alur->movealur($detail->id,'0',3,3);
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
    }
}
