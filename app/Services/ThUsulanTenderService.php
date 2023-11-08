<?php
namespace App\Services;

use App\Models\ThUsulanTender;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThUsulanTenderService{
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
        $model->tipe_tender=request('tipe_tender');
        if ($request->hasFile('file_surat_usulan')) {
            $file = $request->file('file_surat_usulan');
            $uniqueFileName = Str::uuid(40)->toString() . '.pdf';
            $file->storeAs('surat_usulan', $uniqueFileName, 'public');
            $model->file_surat_usulan = $uniqueFileName;
        }
        $model->save();
        return $model;
    }
}