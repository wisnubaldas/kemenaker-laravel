<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ThUsulanTenderUsulpokja extends Model
{
    use HasFactory;
    protected $table = "th_usulan_tender_usulpokja";
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // Hook creating untuk mengisi kolom-kolom secara otomatis sebelum menyimpan data
        static::creating(function ($model) {
            $user = Auth::user();
            $unitkerja=TmUnitkerja::find($user->tmunitkerja_id);
            $model->created_by = $user->id;
            $model->created_date = Carbon::now();
            $model->updated_date = Carbon::now();
            $model->unit_kerja = $unitkerja->unitkerja;
            $model->tmunitkerja_id = $user->tmunitkerja_id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
            $model->updated_date = Carbon::now();
        });
    }
}
