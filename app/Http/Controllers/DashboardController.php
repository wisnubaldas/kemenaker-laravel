<?php

namespace App\Http\Controllers;

use App\Models\ThUsulanTender;
use App\Models\TmJenisTender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {

        $year = '2023';

        $result = TmJenisTender::select('tm_jenis_tender.id', 'tm_jenis_tender.jenis_tender', DB::raw('COUNT(tm_jenis_tender.id) as jmlltender'))
            ->leftJoin('th_usulan_tender_detail as tutd', 'tm_jenis_tender.id', '=', 'tutd.tmjenistender_id')
            ->leftJoin('th_usulan_tender as tut', 'tut.id', '=', 'tutd.thusulantender_id')
            ->whereNotNull('tutd.alur')
            ->whereYear('tut.created_date', $year)
            ->groupBy('tm_jenis_tender.id', 'tm_jenis_tender.jenis_tender')
            ->get();
        $usulan=ThUsulanTender::whereYear('created_date', $year)
        ->whereNotNull('alur')
        ->count('no_surat_usulan');
        $data = [
            "title" => "Dashboard",
            "tenders" => $result,
            "usulan"=>$usulan
        ];
        return view('app.dashboard', $data);
    }
}
