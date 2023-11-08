<?php
    namespace App\Services;

use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderUsulpokja;

class ThUsulanTenderUsulpokjaService{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTenderUsulpokja());
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
    public function newMember($nip, $nama_lengkap, $jabatan, $keterangan, $tender_id){
       return $this->saveMember($this->model,$nip, $nama_lengkap, $jabatan, $keterangan, $tender_id);
    }
    public function updMember($id,$nip, $nama_lengkap, $jabatan, $keterangan, $tender_id){
        return $this->saveMember($this->model->find($id),$nip, $nama_lengkap, $jabatan, $keterangan, $tender_id);
     }
}