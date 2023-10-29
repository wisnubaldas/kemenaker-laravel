<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ThUsulanTender extends Model
{
    use HasFactory;
    protected $table="th_usulan_tender";
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // Hook creating untuk mengisi kolom-kolom secara otomatis sebelum menyimpan data
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->created_date = Carbon::now();
            $model->updated_date = Carbon::now();
            $model->created_unitkerja = $user->tmunitkerja_id;
            $model->tmunitkerja_id = $user->tmunitkerja_id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
            $model->updated_date = Carbon::now();
        });
    }
    public function tmUnitKerja()
    {
        return $this->belongsTo(TmUnitKerja::class, 'tmunitkerja_id', 'id');
    }

    public function usulanTenderDetails()
    {
        return $this->hasMany(ThUsulanTenderDetail::class, 'thusulantender_id', 'id');
    }

    public function getdraft($unit_kerja_id,$owner_id){
        return $this
            ->with('usulanTenderDetails')
            ->select('th_usulan_tender.*')
            ->leftJoin('tm_unitkerja', 'th_usulan_tender.tmunitkerja_id', '=', 'tm_unitkerja.id')
            ->whereNull('th_usulan_tender.alur')
            ->whereNull('th_usulan_tender.posisi')
            ->where('th_usulan_tender.tmunitkerja_id', $unit_kerja_id)
            ->where('th_usulan_tender.created_by', $owner_id);
            
    }
   
}
