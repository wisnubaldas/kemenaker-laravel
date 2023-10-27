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
        $detailusulanlist=(new ThUsulanTenderDetail())->getCompleteData();
        $data=[
            "title"=>"Usulan Tender",
            "data"=>
            $detailusulanlist->when($request->input('tm_unitkerja_id'), function ($query, $tm_unitkerja_id) {
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
    public function detail(Request $request,$usulan_tender_detail_id):View{
        $detailusulanlist=(new ThUsulanTenderDetail())->getCompleteData();
        $data=[
            "title"=>"Usulan Tender",
            "data"=>$detailusulanlist->where('th_usulan_tender_detail.id',$usulan_tender_detail_id)->first()
        ];
        return view('app.usulantenderdetail',$data);
    }
}
