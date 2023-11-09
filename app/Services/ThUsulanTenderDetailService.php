<?php
namespace App\Services;

use App\Http\Requests\STRequest;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Models\ThUsulanTenderPokja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ThUsulanTenderDetailService{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTenderDetail());
    }
    public function savenewdetail($detail, $tender_id)
    {
        $model_detail = $this->model;
        $namaTender = $detail['nama_tender'];
        $tmjenistender_id = $detail['tmjenistender_id'];
        $model_detail->nama_tender = $namaTender;
        $model_detail->thusulantender_id = $tender_id;
        $model_detail->tmjenistender_id = $tmjenistender_id;
        $model_detail->save();
        return $model_detail;
    }
    public function movealur($detail_id,$newalur,$position,$detail_position){
        $detail=$this->model->find($detail_id);
        $detail->alur = $newalur;
        $detail->posisi = $detail_position;
        //$detail->catatan = request('catatan');
        $detail->save();
        $alur=new ThUsulanTenderAlurService();
        $alur->createalur($detail_id,$newalur,$position);
    }
    public function submit_st(STRequest $request, $usulan_tender_detail_id){
        $data = request()->all();
        $user = Auth::user();
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $model = ThUsulanTender::find($model_detail->thusulantender_id);
        $model_detail->nomor_st = request('nomor_st');
        $model_detail->tgl_st = request('tgl_st');
        if ($request->hasFile('surat_st')) {
            $file = $request->file('surat_st');
            $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
            $file->storeAs('_upload', $uniqueFileName, 'public');
            $model_detail->surat_st = $uniqueFileName;
        }
        $model_detail->save();

        foreach ($data['anggota'] as $anggota) {
            (new ThUsulanTenderPokjaService())->submit($anggota,$usulan_tender_detail_id);
        }
        $this->movealur($usulan_tender_detail_id,6,5,5);
    }
}