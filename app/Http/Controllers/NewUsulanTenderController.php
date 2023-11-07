<?php

namespace App\Http\Controllers;

use App\Models\ThUsulanTenderDetail;
use App\Models\TmUnitkerja;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewUsulanTenderController extends Controller
{
    public function index(Request $request): View
    {
        $detailusulanlist = (new ThUsulanTenderDetail())->getCompleteData();
        $user = Auth::user();
        $role = $user->tagroup_id;
        switch ($role) {
            case 1:
                $detailusulanlist
                    ->join('th_usulan_tender_pokja', function ($join) use ($user) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', $user->thanggotapokja_id);
                    });
                break;
            case 2:
                $detailusulanlist
                    ->where('th_usulan_tender.tmunitkerja_id', $user->tmunitkerja_id)
                    ->where('th_usulan_tender.created_by', $user->id);
                break;
            case 5:
                $detailusulanlist
                    ->join('th_usulan_tender_pokja', function ($join) use ($user) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', $user->thanggotapokja_id);
                    });
                break;
        }
        $data = [
            "title" => "Usulan Tender",
            "data" =>
            $detailusulanlist
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
            "tm_unitkerja" => (new TmUnitkerja())->getSortedUnitKerja()

        ];

        // dd($data['data']);
        return view('app.newusulantender', $data);
    }
}
