<?php

namespace App\Http\Controllers;

use App\Models\ThUsulanTender;
use App\Models\ThUsulanTenderDetail;
use App\Services\ThUsulanTenderDetailService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UsulanTenderDetailController extends Controller
{
    private function getdirection($detail_id){
        $detail=ThUsulanTenderDetail::find($detail_id);
        $model=ThUsulanTender::find($detail->thusulantender_id);
        $to = ['usulan-tender', 'usulan-tender-seleksi', 'usulan-tender-dikecualikan'];
        return $to[$model->tipe_tender];
    }
    public function deploy_lpse(Request $request, $usulan_tender_detail_id): RedirectResponse
    {
        $to=$this->getdirection($usulan_tender_detail_id);
        DB::beginTransaction();
        try {
            if (request('delegasi') == 'YES') {
                $alur = new ThUsulanTenderDetailService();
                $alur->movealur($usulan_tender_detail_id, 12, 5, 5);
              
                DB::commit();
            }
            return redirect()->route($to)->with(
                'success',
                'Berhasil mem-verifikasi penayangan LPSE.'
            );
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public function submit_ba_pemilihan(Request $request, $usulan_tender_detail_id): RedirectResponse
    {
        DB::beginTransaction();
        $to=$this->getdirection($usulan_tender_detail_id);
        $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
        $validated = $request->validate([
            'ba_hasil_pemilihan' => 'required|file|mimes:pdf|max:225000',
        ], [
            'ba_hasil_pemilihan.required' => "Berita Acara Hasil Pemilihan Tidak Boleh Kosong",
            'ba_hasil_pemilihan.file' => "Data harus berupa file",
            'ba_kajba_hasil_pemilihani_ulang.mimes' => 'File harus berpa pdf',
            'ba_hasil_pemilihan.max' => 'File tidak boleh leboh dari 25Mb'
        ]);
        try {
            $model_detail = ThUsulanTenderDetail::find($usulan_tender_detail_id);
            if ($request->hasFile('ba_hasil_pemilihan')) {
                $file = $request->file('ba_hasil_pemilihan');
                $uniqueFileName = Str::uuid(30)->toString() . '.pdf';
                $file->storeAs('_upload', $uniqueFileName, 'public');
                $model_detail->ba_hasil_pemilihan = $uniqueFileName;
            } else {
                throw new Exception("File Not Found");
            }

           
            $model_detail->save();

            $this->savealur(13, 2, $usulan_tender_detail_id);
            $model_detail->alur = 13;
            $model_detail->posisi = 2;
            DB::commit();
            return redirect()->route($to)->with(
                'success',
                'Unggah Berita Acara Hasil Pemilihan Berhasil.'
            );;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
