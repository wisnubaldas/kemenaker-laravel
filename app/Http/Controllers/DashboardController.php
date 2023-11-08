<?php

namespace App\Http\Controllers;

use App\Models\ThUsulanTender;
use App\Models\TmJenisTender;
use App\Models\TmJenisTenderDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {

        $year = '2023';

        $summary=(new TmJenisTender())->summary();
        $result = $summary
            ->whereYear('tut.created_date', $year)
            ->groupBy('tm_jenis_tender.id', 'tm_jenis_tender.jenis_tender')
            ->get();

        $alltendersum=(new TmJenisTender())->summary()->groupBy('tm_jenis_tender.id', 'tm_jenis_tender.jenis_tender')
        ->get();
        $sum=$alltendersum->sum('jmlltender');
       // dd($alltendersum);
        $usulan=ThUsulanTender::whereYear('created_date', $year)
        ->whereNotNull('alur')
        ->count('no_surat_usulan');

      //  $datacart = $alltendersum->pluck('jmlltender')->toArray();
        $labelscart = $alltendersum->pluck('jenis_tender')->toArray();
        //$count = count($datacart);
        
       // data: { datasets: [{ data: [50, 40, 10], backgroundColor: ["#00A3FF", "#50CD89", "#E4E6EF"] }], labels: ["Active", "Completed", "Yet to start"] },
        $values=[];
        $bgColor=[];
        $baseBgColors =["#009EF7","#50CD89","#FFC700","#7239EA","#E4E6EF","#F1416C"];
        $i=0;
        foreach($alltendersum as $tender){
            if($i>$alltendersum->count()){
                $i=0;
            }
            array_push($values,$tender->jmlltender);
            array_push($bgColor,$baseBgColors[$i]);
            $i++;
        }
        $datasets[] = [
            'data' => $values,
            'backgroundColor' => $baseBgColors,
        ]; 
      
        
        $chartData = [
            'datasets' => $datasets,
            'labels' => $labelscart,
        ];
        $data = [
            "title" => "Dashboard",
            "tenders" => $result,
            "usulan"=>$usulan,
            "cartsum"=>$alltendersum,
            "chartData"=>$chartData
        ];
        return view('app.dashboard', $data);
    }
    public function getDocs($jenis_tender_id){
        $documents = TmJenisTenderDoc::where('tmjenistender_id', $jenis_tender_id)->get();
        return response()->json($documents);
    }
}
