<?php
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewUsulanTenderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsulanTenderController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'login'])->name('submitlogin');
   
});
Route::group(['middleware'=>'role:1,2,3,4,5'],function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/usulan-tender', [UsulanTenderController::class, 'index'])->name('usulan-tender');
    Route::get('/usulan-tender-seleksi', [NewUsulanTenderController::class, 'seleksi'])->name('usulan-tender-seleksi');
    Route::get('/usulan-tender-pengecualian', [NewUsulanTenderController::class, 'pengecualian'])->name('usulan-tender-pengecualian');
    Route::get('/usulan-tender-detail/{tender_detail_id}', [UsulanTenderController::class, 'detail'])->name('usulan-tender-detail');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('profile', [ProfileController::class, 'create'])->name('profile');
});
Route::group(['middleware'=>'role:1'],function () {
    Route::get('/usulan-ppk', [AuthenticatedSessionController::class, 'dashboard'])->name('usulan-ppk');
    Route::get('/anggota-pokja', [AuthenticatedSessionController::class, 'dashboard'])->name('anggota-pokja');
    Route::get('/jenis-tender', [UsulanTenderController::class, 'index'])->name('jenis-tender');
    Route::get('/unit-kerja', [AuthenticatedSessionController::class, 'dashboard'])->name('unit-kerja');
    Route::get('/group', [AuthenticatedSessionController::class, 'dashboard'])->name('group');
    Route::get('/user', [AuthenticatedSessionController::class, 'dashboard'])->name('user');

});

Route::group(['middleware'=>'role:2'],function () {
    Route::get('/usulan-tender/draft', [NewUsulanTenderController::class, 'draftlist'])->name('draft-usulan-tender');
    Route::get('/usulan-tender-seleksi/draft', [NewUsulanTenderController::class, 'draftlistseleksi'])->name('draft-usulan-tender-seleksi');
    Route::get('/usulan-tender-pengecualian/draft', [NewUsulanTenderController::class, 'draftlistdikecualikan'])->name('draft-usulan-tender-pengecualian');

    Route::get('/usulan-tender/new', [NewUsulanTenderController::class, 'newdraft'])->name('new-usulan-tender');
    Route::get('/usulan-tender-seleksi/new', [NewUsulanTenderController::class, 'newdraftseleksi'])->name('new-usulan-tender-seleksi');
    Route::get('/usulan-tender-dikecualikan/new', [NewUsulanTenderController::class, 'newdraftdikecualikan'])->name('new-usulan-tender-dikecualikan');
   
    Route::post('/usulan-tender/new', [NewUsulanTenderController::class, 'submit_newdraft'])->name('submit-new-usulan-tender');
    Route::post('/usulan-tender-seleksi/new', [NewUsulanTenderController::class, 'submit_newdraft'])->name('submit-new-usulan-tender-seleksi');
    Route::post('/usulan-tender-dikecualikan/new', [NewUsulanTenderController::class, 'submit_newdraft'])->name('submit-new-usulan-tender-dikecualikan');

    Route::post('/berkas/update/{doc_id}', [NewUsulanTenderController::class, 'updateberkas'])->name('update-berkas');


    Route::get('/usulan-tender/edit/{tender_id}', [UsulanTenderController::class, 'editdraft'])->name('edit-usulan-tender');
    Route::get('/usulan-tender-seleksi/edit/{tender_id}', [NewUsulanTenderController::class, 'editdraft_seleksi'])->name('edit-usulan-tender-seleksi');
    Route::get('/usulan-tender-dikecualikan/edit/{tender_id}', [NewUsulanTenderController::class, 'editdraft_dikecualikan'])->name('edit-usulan-tender-dikecualikan');


    Route::post('/usulan-tender/edit/{tender_id}', [UsulanTenderController::class, 'updatedraft'])->name('update-usulan-tender');
    Route::post('/usulan-tender/send/{tender_id}', [UsulanTenderController::class, 'send'])->name('send-usulan-tender');
    Route::post('/usulan-tender/lpse/{tender_detail_id}', [UsulanTenderController::class, 'updatelpse'])->name('submit-lpse-usulan-tender');
    Route::post('/usulan-tender/sph/{tender_detail_id}', [UsulanTenderController::class, 'submit_sph'])->name('submit-sph-usulan-tender');
    Route::post('/usulan-tender/resend/{tender_detail_id}', [UsulanTenderController::class, 'sendAfterReject'])->name('resend-usulan-tender');
    
});

Route::group(['middleware'=>'role:3'],function () {
    Route::get('/test',function(){
        return "OK";
    });
    Route::post('/usulan-tender/approve/{tender_detail_id}', [UsulanTenderController::class, 'approvetender'])->name('approve-usulan-tender');
    Route::post('/usulan-tender/reject/{tender_detail_id}', [UsulanTenderController::class, 'rejecttender'])->name('reject-usulan-tender');
    Route::post('/usulan-tender/st/{tender_detail_id}', [UsulanTenderController::class, 'submit_st'])->name('submit-st-usulan-tender');
    Route::post('/usulan-tender/deploy/{tender_detail_id}', [UsulanTenderController::class, 'deploy_lpse'])->name('deploy-usulan-tender');
   
});
Route::group(['middleware'=>'role:4'],function () {
    Route::post('/usulan-tender/delegate/{tender_detail_id}', [UsulanTenderController::class, 'submit_delegate'])->name('delegate-usulan-tender');
});
Route::group(['middleware'=>'role:5'],function () {
    Route::post('/usulan-tender/ba/{tender_detail_id}', [UsulanTenderController::class, 'submit_ba'])->name('submit-ba-usulan-tender');
    Route::post('/usulan-tender/ba-choose/{tender_detail_id}', [UsulanTenderController::class, 'submit_ba_pemilihan'])->name('submit-ba-pemilihan-usulan-tender');
});