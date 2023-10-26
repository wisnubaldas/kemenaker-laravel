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
}
