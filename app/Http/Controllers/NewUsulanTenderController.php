<?php

namespace App\Http\Controllers;

use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Models\TmUnitkerja;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewUsulanTenderController extends Controller
{
    public function index(Request $request): View{
        $detailusulanlist = (new ThUsulanTenderDetail())->basequery();
        $user = Auth::user();
        $role = $user->tagroup_id;
        $data = [
            "title" => "Usulan Tender Seleksi",
            "tipe_tender"=>0,
            "data" =>
            $detailusulanlist
                ->where('th_usulan_tender.tipe_tender', 0)
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
        return view('app.newusulantender', $data);
    }
    public function seleksi(Request $request): View{
        $detailusulanlist = (new ThUsulanTenderDetail())->basequery();
        $user = Auth::user();
        $role = $user->tagroup_id;
        $data = [
            "title" => "Usulan Tender Seleksi",
            "tipe_tender"=>1,
            "data" =>
            $detailusulanlist
                ->where('th_usulan_tender.tipe_tender', 1)
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
        return view('app.newusulantender', $data);
    }
    public function pengecualian(Request $request): View{
        $detailusulanlist = (new ThUsulanTenderDetail())->basequery();
        $user = Auth::user();
        $role = $user->tagroup_id;
        $data = [
            "title" => "Usulan Tender Dikecualikan",
            "tipe_tender"=>2,
            "data" =>
            $detailusulanlist
                ->where('th_usulan_tender.tipe_tender', 2)
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
        return view('app.newusulantender', $data);
    }
    public function draftlist(Request $request): View
    {
        $detailusulanlist = (new ThUsulanTender())->draft(0);
        $data = $detailusulanlist;
        return view('app.draftusulantender', $data);
    }
    public function draftlistseleksi(Request $request): View
    {
        $detailusulanlist = (new ThUsulanTender())->draft(1);
        $data = $detailusulanlist;
        return view('app.draftusulantender', $data);
    }
    public function draftlistdikecualikan(Request $request): View
    {
        $detailusulanlist = (new ThUsulanTender())->draft(2);
        $data = $detailusulanlist;
        return view('app.draftusulantender', $data);
    }

}
