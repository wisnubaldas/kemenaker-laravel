<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TmJenisTender extends Model
{
    use HasFactory;
    protected $table="tm_jenis_tender";
    public function usulanTenderDetails()
    {
        return $this->hasMany(ThUsulanTenderDetail::class, 'tmjenistender_id');
    }
    public function jenisTenderDocs(){
        return $this->hasMany(TmJenisTenderDoc::class,'tmjenistender_id');
    }
    public function summary(){
        return $this->select('tm_jenis_tender.id', 'tm_jenis_tender.jenis_tender', DB::raw('COUNT(tm_jenis_tender.id) as jmlltender'))
        ->leftJoin('th_usulan_tender_detail as tutd', 'tm_jenis_tender.id', '=', 'tutd.tmjenistender_id')
        ->leftJoin('th_usulan_tender as tut', 'tut.id', '=', 'tutd.thusulantender_id')
        ->whereNotNull('tutd.alur');
    }
}
