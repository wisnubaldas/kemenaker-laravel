<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThUsulanTenderDetail extends Model
{
    use HasFactory;
    protected $table="th_usulan_tender_detail";

    public function usulanTender()
    {
        return $this->belongsTo(ThUsulanTender::class, 'thusulantender_id', 'id');
    }

    public function tmJenisTender()
    {
        return $this->belongsTo(TmJenisTender::class, 'tmjenistender_id', 'id');
    }

    public function usulanTenderPokja()
    {
        return $this->hasOne(ThUsulanTenderPokja::class, 'thusulantenderdetail_id', 'id');
    }

    // Relasi dengan TmUnitKerja mungkin tidak terlihat dalam kueri SQL Anda
    public function usulanTenderUnitKerja()
    {
        return $this->belongsTo(TmUnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function getCompleteData(){
        return $this->select(
            'th_usulan_tender_detail.*',
            'th_usulan_tender.no_surat_usulan',
            'th_usulan_tender.keterangan',
            'ta_group.nama_group',
            'tm_unitkerja.unitkerja',
            'tm_jenis_tender.jenis_tender'
        )
        ->leftJoin('th_usulan_tender', 'th_usulan_tender_detail.thusulantender_id', '=', 'th_usulan_tender.id')
        ->leftJoin('tm_unitkerja', 'th_usulan_tender.tmunitkerja_id', '=', 'tm_unitkerja.id')
        ->leftJoin('tm_jenis_tender', 'th_usulan_tender_detail.tmjenistender_id', '=', 'tm_jenis_tender.id')
        ->leftJoin('ta_group','th_usulan_tender_detail.posisi','=','ta_group.id')
        ->whereNotNull('th_usulan_tender.alur')
        ->whereNotNull('th_usulan_tender.posisi');
    }
}
