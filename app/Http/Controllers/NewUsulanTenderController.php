<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewDraftUsulanRequest;
use App\Http\Requests\STRequest;
use App\Models\ThAnggotaPokja;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Models\ThUsulanTenderDetailDoc;
use App\Models\ThUsulanTenderUsulpokja;
use App\Models\TmJenisTender;
use App\Models\TmUnitkerja;
use App\Services\ThUsulanTenderDetailDocService;
use App\Services\ThUsulanTenderDetailService;
use App\Services\ThUsulanTenderService;
use App\Services\ThUsulanTenderUsulpokjaService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewUsulanTenderController extends Controller
{
    public function index(Request $request): View
    {
        $data = (new ThUsulanTenderDetail())->basequery($request, 0);
        return view('app.newusulantender', $data);
    }
    public function seleksi(Request $request): View
    {
        $data = (new ThUsulanTenderDetail())->basequery($request, 1);
        return view('app.newusulantender', $data);
    }
    public function pengecualian(Request $request): View
    {
        $data = (new ThUsulanTenderDetail())->basequery($request, 2);
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

    public function newdraft(Request $request): View
    {
        $data = (new ThUsulanTender())->newdraftdata(0);
        return view('app.formusulantender', $data);
    }
    public function newdraftseleksi(Request $request): View
    {
        $data = (new ThUsulanTender())->newdraftdata(1);
        return view('app.formusulantendernew', $data);
    }
    public function newdraftdikecualikan(Request $request): View
    {
        $data = (new ThUsulanTender())->newdraftdata(2);
        return view('app.formusulantendernew', $data);
    }

    public function submit_newdraft(NewDraftUsulanRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $result = (new ThUsulanTenderService)->submit_service($request);
            DB::commit();
            $to = ['draft-usulan-tender', 'draft-usulan-tender-seleksi', 'draft-usulan-tender-dikecualikan'];
            return redirect()->route($to[request('tipe_tender')])
                ->with(
                    'success',
                    $result
                );
        } catch (Exception $e) {

            DB::rollBack();
            return redirect()->route('new-usulan-tender-seleksi')->with('error', $e->getMessage())->withInput();
        }
    }

    public function updateberkas(Request $request, $id_doc)
    {
        $validated = $request->validate([
            'berkas' => 'required|file|mimes:pdf|max:25000',
        ]);
        $detailDocService = new ThUsulanTenderDetailDocService();
        $detailDocService->updateberkas($request, $id_doc);
    }
    public function editdraft_seleksi(Request $request, $tender_id): View
    {

        $data = (new ThUsulanTender())->edit(1, $tender_id);
        return view('app.formusulantendernew', $data);
    }
    public function editdraft_dikecualikan(Request $request, $tender_id): View
    {

        $data = (new ThUsulanTender())->edit(2, $tender_id);
        return view('app.formusulantendernew', $data);
    }

    public function updatedraft(Request $request, $tender_id): RedirectResponse
    {
        try {
            $result = (new ThUsulanTenderService)->update_service($request, $tender_id);
            DB::commit();
            $to = ['draft-usulan-tender', 'draft-usulan-tender-seleksi', 'draft-usulan-tender-dikecualikan'];
            return redirect()->route($to[request('tipe_tender')])
                ->with(
                    'success',
                    $result
                );
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
    public function send($id)
    {
        DB::beginTransaction();
        try {
            $model = (new ThUsulanTenderService())->send($id);
            DB::commit();
            return $model;
        } catch (Exception $e) {
            //dd($e);
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    private function isApprove(Request $request, $usulan_tender_detail_id, $is_approve)
    {
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $alur = new ThUsulanTenderDetailService();
        if ($is_approve) {
            if ($model_detail->alur == 7) {
                $alur->movealur($usulan_tender_detail_id, 9, null, 2);
            } elseif ($model_detail->alur == 13) {
                $alur->movealur($usulan_tender_detail_id, 16, null, 3);
            } elseif ($model_detail->alur == 16) {
                $alur->movealur($usulan_tender_detail_id, 18, null, 3);
            } elseif ($model_detail->alur == 0) {
                $alur->movealur($usulan_tender_detail_id, 3, 3, 4);
            }else{}
        } else {
            if ($model_detail->alur == 7) {
                $alur->movealur($usulan_tender_detail_id, 8, null, 5);
            } elseif ($model_detail->alur == 13) {
                $alur->movealur($usulan_tender_detail_id, 14, 5, 5);
            } elseif ($model_detail->alur == 16) {
                $alur->movealur($usulan_tender_detail_id, 17, null, 2);
            } elseif ($model_detail->alur == 0) {
                $alur->movealur($usulan_tender_detail_id, 2, 2, 2);
            }else{}
        }
    }
    public function approvetender(Request $request, $usulan_tender_detail_id)
    {
        $this->isApprove($request, $usulan_tender_detail_id, true);
    }
    public function rejecttender(Request $request, $usulan_tender_detail_id)
    {
        $this->isApprove($request, $usulan_tender_detail_id, false);
    }
    private function getdirection($detail_id){
        $detail=ThUsulanTenderDetail::find($detail_id);
        $model=ThUsulanTender::find($detail->thusulantender_id);
        $to = ['usulan-tender', 'usulan-tender-seleksi', 'usulan-tender-dikecualikan'];
        return $to[$model->tipe_tender];
    }
    public function submit_st(STRequest $request, $usulan_tender_detail_id): RedirectResponse
    {
         $to=$this->getdirection($usulan_tender_detail_id);
        // dd($to);
        DB::beginTransaction();

      
        try {
            $save=(new ThUsulanTenderDetailService())->submit_st($request,$usulan_tender_detail_id);
            DB::commit();
          
            return redirect()->route($to)->with(
                'success',
                'Berhasil Update Nomor Surat Tugas.'
            );
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
