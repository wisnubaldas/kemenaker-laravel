<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmJenisTender extends Model
{
    use HasFactory;
    protected $table="tm_jenis_tender";
    public function usulanTenderDetails()
    {
        return $this->hasMany(ThUsulanTenderDetail::class, 'tmjenistender_id');
    }
}
