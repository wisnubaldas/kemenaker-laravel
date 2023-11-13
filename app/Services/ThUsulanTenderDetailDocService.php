<?php
namespace App\Services;

use App\Models\ThUsulanTenderDetailDoc;
use App\Models\TmJenisTenderDoc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThUsulanTenderDetailDocService{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTenderDetailDoc());
    }
    public function savedoc($detail_id, $doc)
    {
        $model_doc = $this->model;
        $model_doc->thusulantenderdetail_id = $detail_id;
        $model_doc->tmjenistenderdoc_id = $doc["tmjenistenderdoc_id"];
       
        $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
        $file = $doc['berkas'];
        $file->storeAs('_upload', $uniqueFileName, 'public');
        if($doc["tmjenistenderdoc_id"]!=0){
            $tipe_doc=TmJenisTenderDoc::find($doc["tmjenistenderdoc_id"]);
            $model_doc->nama_berkas = $tipe_doc->nama_doc;
        }else{
            $model_doc->nama_berkas = $doc['nama_berkas'];
        }
        $model_doc->berkas = $uniqueFileName;
        $model_doc->save();
        return $model_doc;
    }
    public function updateberkas($request,$id){
        $model_doc=$this->model->find($id);
        if ($request->hasFile('berkas')) {
            if (Storage::disk('public')->exists('_upload/' . $model_doc->berkas)) {
                Storage::disk('public')->delete('_upload/' . $model_doc->berkas);
            }
            $file = $request->file('berkas');
            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
            $file->storeAs('_upload', $uniqueFileName, 'public');
            $model_doc->berkas = $uniqueFileName;
            $model_doc->save();
        }
    }
}