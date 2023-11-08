<?php
namespace App\Services;

use App\Models\ThUsulanTenderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThUsulanTenderDetailService{
    private $model;
    public function __construct()
    {
        $this->model = (new ThUsulanTenderDetail());
    }
    public function savenewdetail($detail, $tender_id)
    {
        $model_detail = $this->model;
        $namaTender = $detail['nama_tender'];
        $tmjenistender_id = $detail['tmjenistender_id'];
        $model_detail->nama_tender = $namaTender;
        $model_detail->thusulantender_id = $tender_id;
        $model_detail->tmjenistender_id = $tmjenistender_id;
        $model_detail->save();
        return $model_detail;
    }
}