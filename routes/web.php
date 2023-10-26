<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsulanTenderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'login'])->name('submitlogin');
});
Route::group(['middleware'=>'role:1,2,3,4,5'],function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/usulan-tender', [UsulanTenderController::class, 'index'])->name('usulan-tender');
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