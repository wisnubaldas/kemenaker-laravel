<?php

namespace App\Http\Controllers;

use App\Models\TaGroup;
use App\Models\TaUsulanTender;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Models\TmUnitkerja;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsulanTenderController extends Controller
{
    public function index(Request $request):View{

       // dd($request->all());
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
            ->when($request->input('tm_unitkerja_id'), function ($query, $tm_unitkerja_id) {
                return $query->where('th_usulan_tender.tmunitkerja_id', $tm_unitkerja_id);
            })
            ->when($request->input('no_surat_usulan'), function ($query, $no_surat_usulan) {
                return $query->where('th_usulan_tender.no_surat_usulan', 'like', '%' . $no_surat_usulan . '%');
            })
            ->when($request->input('nama_tender'), function ($query, $nama_tender) {
                return $query->where('th_usulan_tender_detail.nama_tender', 'like', '%' . $nama_tender . '%');
            })
            ->orderBy('th_usulan_tender_detail.updated_date', 'DESC')
            ->paginate(20),
            "tm_unitkerja"=>(new TmUnitkerja())->getSortedUnitKerja()
           
        ];
      
        //dd($data['data']);
        return view('app.usulantender',$data);
    }
}
