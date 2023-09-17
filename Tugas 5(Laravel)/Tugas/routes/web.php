<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RakController;
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

/*Route::get('/welcome', function () {
    return view('welcome')->name('welcome');
});

Route::get('/form', function () {
    return view('form')->name('form');
});
*/
Route::get('/master', [MasterController::class, 'master'])->name('master');
Route::get('/', [MasterController::class, 'content'])->name('index');
Route::resource('/anggota', AnggotaController::class);
Route::resource('/buku', BukuController::class);
Route::resource('/peminjaman', PeminjamanController::class);
Route::resource('/pengembalian', PengembalianController::class);
Route::resource('/petugas', PetugasController::class);
Route::resource('/rak', RakController::class);

