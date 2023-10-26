<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThUsulanTender extends Model
{
    use HasFactory;
    protected $table="th_usulan_tender";

    public function tmUnitKerja()
    {
        return $this->belongsTo(TmUnitKerja::class, 'tmunitkerja_id', 'id');
    }

    public function usulanTenderDetails()
    {
        return $this->hasMany(ThUsulanTenderDetail::class, 'thusulantender_id', 'id');
    }
}
