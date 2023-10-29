<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewDraftUsulanRequest;
use App\Models\TaGroup;
use App\Models\TaUsulanTender;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Models\TmUnitkerja;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class UsulanTenderController extends Controller
{
    public function index(Request $request):View{

       // dd($request->all());
        $detailusulanlist=(new ThUsulanTenderDetail())->getCompleteData();
        $user=Auth::user();
        $role=$user->tagroup_id;
        switch ($role){
            case 1:
                $detailusulanlist
                ->join('th_usulan_tender_pokja', function ($join) {
                    $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                        ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', 55);
                });
                break;
            case 2:
                $detailusulanlist
                ->where('th_usulan_tender.tmunitkerja_id',$user->tmunitkerja_id)
                ->where('th_usulan_tender.created_by',$user->id);

        }
        $data=[
            "title"=>"Usulan Tender",
            "data"=>
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
    public function submit_newdraft(NewDraftUsulanRequest $request):RedirectResponse{
        $model = new ThUsulanTender();
       
        $model->no_surat_usulan=$request->input('no_surat_usulan');
        $model->keterangan=$request->input('keterangan');
        if ($request->hasFile('file_surat_usulan')) {
            $file = $request->file('file_surat_usulan');
            $uniqueFileName = Str::random(20) . '.pdf';

            // Menyimpan file ke direktori surat_usulan dengan nama unik
            
            $file->storeAs('surat_usulan', $uniqueFileName);
        
            $model->file_surat_usulan=$uniqueFileName;
          
        }
        $model->save();
        if ($model->wasRecentlyCreated) {
            // Jika berhasil, arahkan ke halaman daftar draft
            return redirect()->route('draft-usulan-tender')->with('success', 'Usulan berhasil disimpan.');
        } else {
            // Jika gagal, kembali ke halaman formulir dengan data input sebelumnya
            return redirect()->route('new-usulan-tender')->withInput();
        }
    }

    public function newdraft(Request $request):View{
        $detailusulanlist=(new ThUsulanTenderDetail())->getCompleteData();
        $data=[
            "title"=>"Usulan Tender",
           // "data"=>$detailusulanlist->where('th_usulan_tender_detail.id',$usulan_tender_detail_id)->first()
        ];
        return view('app.usulantenderdetail',$data);
    }

    public function draftlist(Request $request):View{

        // dd($request->all());
         
         $user=Auth::user();
         $role=$user->tagroup_id;
         $detailusulanlist=(new ThUsulanTender())->getdraft($user->tmunitkerja_id,$user->id);
         //dd($detailusulanlist);
         $data=[
             "title"=>"Usulan Tender",
             "data"=>$detailusulanlist
             ->orderByDesc('th_usulan_tender.created_date')
             ->paginate(20),
             "tm_unitkerja"=>(new TmUnitkerja())->getSortedUnitKerja()
            
         ];
       
         //dd($data['data']);
         return view('app.draftusulantender',$data);
     }
}
