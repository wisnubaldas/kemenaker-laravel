<?php
    namespace App\Services;

use App\Models\ThAnggotaPokja;
use App\Models\ThUsulanTenderPokja;

class ThUsulanTenderPokjaService{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTenderPokja());
    }
    public function submit($anggota,$usulan_tender_detail_id){
        $anggotanya = ThAnggotaPokja::find($anggota);
        $pokja = $this->model;
        $pokja->nip = $anggotanya->nip;
        $pokja->jabatan = $anggotanya->jabatan;
        $pokja->unit_kerja = $anggotanya->unit_kerja;
        $pokja->nama_lengkap = $anggotanya->nama_lengkap;
        $pokja->thusulananggotapokja_id = $anggotanya->id;
        $pokja->thusulantenderdetail_id = $usulan_tender_detail_id;
        $pokja->tmunitkerja_id = $anggotanya->tmunitkerja_id;
        $pokja->save();
        return $pokja;
    }
}