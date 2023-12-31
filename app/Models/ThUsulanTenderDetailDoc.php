<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ThUsulanTenderDetailDoc extends Model
{
    use HasFactory;
    protected $table="th_usulan_tender_detail_doc";
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();

        // Hook creating untuk mengisi kolom-kolom secara otomatis sebelum menyimpan data
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->created_date = Carbon::now();
        });
    }
}
