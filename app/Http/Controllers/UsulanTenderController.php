<?php

namespace App\Http\Controllers;

use App\Models\TaGroup;
use App\Models\TaUsulanTender;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsulanTenderController extends Controller
{
    public function index():View{

        $data=[
            "title"=>"Usulan Tender",
            "data"=>ThUsulanTenderDetail::select(
                'th_usulan_tender_detail.*',
                'th_usulan_tender.no_surat_usulan',
                'ta_group.nama_group',
                'tm_unitkerja.unitkerja',
                'tm_jenis_tender.jenis_tender'
            )
            ->leftJoin('th_usulan_tender', 'th_usulan_tender_detail.thusulantender_id', '=', 'th_usulan_tender.id')
            ->leftJoin('tm_unitkerja', 'th_usulan_tender.tmunitkerja_id', '=', 'tm_unitkerja.id')
            ->leftJoin('tm_jenis_tender', 'th_usulan_tender_detail.tmjenistender_id', '=', 'tm_jenis_tender.id')
            ->join('th_usulan_tender_pokja', function ($join) {
                $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                    ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', 55);
            })
            ->leftJoin('ta_group','th_usulan_tender_detail.posisi','=','ta_group.id')
            ->whereNotNull('th_usulan_tender.alur')
            ->whereNotNull('th_usulan_tender.posisi')
            ->orderBy('th_usulan_tender_detail.updated_date', 'DESC')
            ->paginate(20),
            "ta_group"=>TaGroup::where('status', '=', 1)
            ->where('id', '<>', 1)
            ->orderBy('id')
            ->get()
           
        ];
      
        //dd($data['data']);
        return view('app.usulantender',$data);
    }
}
