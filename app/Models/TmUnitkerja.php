<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmUnitkerja extends Model
{
    use HasFactory;
    protected $table="tm_unitkerja";
    protected $fillable = ['id', 'unitkerja'];
    public function getSortedUnitKerja()
    {
        return $this->select('id', 'unitkerja')
                    ->orderBy('unitkerja')
                    ->get();
    }
}
