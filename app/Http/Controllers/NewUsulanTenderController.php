<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewDraftUsulanRequest;
use App\Models\ThAnggotaPokja;
use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
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
use Illuminate\Support\Facades\Validator;

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
            $errTenderDetCount = 0;
            $errDocCount = 0;
            $errMemberCount = 0;
            $registeredpokja = 0;
            $result = $this->submit_service($request);
            DB::commit();
            return redirect()->route('draft-usulan-tender-seleksi')
                ->with(
                    'success',
                    $result
                );
        } catch (Exception $e) {
        
            DB::rollBack();
            dd($e);
            return redirect()->route('new-usulan-tender-seleksi')->with('error',$e->getMessage())->withInput();
        }
    }
    private function submit_service(NewDraftUsulanRequest $request)
    {
        $errTenderDetCount = 0;
        $errDocCount = 0;
        $errMemberCount = 0;
        $registeredpokja = 0;
        $modelService = new ThUsulanTenderService();
        $model = $modelService->savenewtender($request);
        $usulanTenderDetails = $request->input('usulanTenderDetails');
        foreach ($usulanTenderDetails as $index => $detail) {
          //  dd($detail);
            $validator = Validator::make($detail, [
                'nama_tender' => 'required',
                'tmjenistender_id' => 'required'
            ]);
            if ($validator->fails()) {
                $errTenderDetCount++;
            } else {
                $detailService = new ThUsulanTenderDetailService();
                $model_detail = $detailService->savenewdetail($detail, $model->id);
                $docs = request('usulanTenderDetails')[$index]['usulanTenderDetailDoc'];
                foreach ($docs as $i => $doc) {
                   
                    $docsValidator = Validator::make($doc, [
                    //     'nama_berkas' => 'required',
                        'berkas' => 'nullable|file|mimes:pdf|max:25000',
                        'tmjenistenderdoc_id'=>'required'
                    ]);
                   // dd($docsValidator->fails());
                    if (!$docsValidator->fails()) {
                       
                        $detailDocService = new ThUsulanTenderDetailDocService();
                        $detailDocService->savedoc($model_detail->id, $doc);
                    } else {
                        $errDocCount++;
                    }
                }
            }
        }
        $members = $request->input('pokja');
        foreach ($members as $member) {
            $membervalidator = Validator::make($member, [
                'nip' => 'required:max:20',
                'nama_lengkap' => 'nullable|max:100',
                'jabatan' => 'nullable|max:50',
                'keterangan' => 'nullable|max:250',
            ]);
            if ($membervalidator->fails()) {
                $errMemberCount++;
            } else {
                $nip = $member['nip'];
                $ceknip = ThAnggotaPokja::where('nip', $nip)->first();
                if ($ceknip) {
                    $registeredpokja++;
                } else {
                    $servicePokja = new ThUsulanTenderUsulpokjaService();
                    $servicePokja->newMember($nip, $member['nama_lengkap'], $member['jabatan'], $member['keterangan'], $model->id);
                }
            }
        }
        return  'Usulan berhasil disimpan. '
            . $errTenderDetCount . ' Tender Gagal Tersimpan dan '
            . $errDocCount . ' Dokumen Gagal Tersimpan dan '
            . $errMemberCount . ' Anggota Gagal Tersimpan dan '
            . $registeredpokja . ' Usulan Anggota Pokja Sudah ada dalam database';
    }
    public function updateberkas(Request $request,$id_doc){
        $validated = $request->validate([
            'berkas' => 'required|file|mimes:pdf|max:25000',
        ]);
        $detailDocService = new ThUsulanTenderDetailDocService();
        $detailDocService->updateberkas($request, $id_doc);
    }
    public function editdraft_seleksi(Request $request, $tender_id): View
    {
        $data = ThUsulanTender::with('usulanTenderDetails.usulanTenderDetailDoc', 'usulanTenderUsulPokja')
            ->where('id', $tender_id)
            ->first();
        $data = [
            "title" => "Usulan Tender",
            "tipe_tender"=>1,
            "jenis_tender" => TmJenisTender::orderby('jenis_tender')->get(),
            "is_edit" => true,
            "data" => $data
        ];
        return view('app.formusulantendernew', $data);
    }
}
