<?php
namespace App\Services;

use App\Models\ThUsulanTenderAlur;
use Illuminate\Support\Facades\Auth;

class ThUsulanTenderAlurService{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTenderAlur());
    }
    public function createalur($detail_id,$newalur,$posisi){
        $user=Auth::user();
        $alur = $this->model;
        $alur->thusulantenderdetail_id = $detail_id;
        $alur->tagroup_id = $user->tagroup_id;
        $alur->alur = $newalur;
        $alur->posisi = $posisi;
        $alur->save();
    }
}