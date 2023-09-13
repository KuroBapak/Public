<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RakController;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\rak;
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
Route::get('/anggota', [AnggotaController::class, 'anggota'])->name('anggota');
Route::get('/buku', [BukuController::class, 'buku'])->name('buku');
Route::get('/peminjaman', [PeminjamanController::class, 'peminjaman'])->name('peminjaman');
Route::get('/pengembalian', [PengembalianController::class, 'pengembalian'])->name('pengembalian');
Route::get('/petugas', [PetugasController::class, 'petugas'])->name('petugas');
Route::get('/rak', [RakController::class, 'rak'])->name('rak');

Route::post('/anggota/store', [AnggotaController::class, 'storeAnggota']);
Route::post('/buku/store', [BukuController::class, 'storeBuku']);
Route::post('/peminjaman/store', [PeminjamanController::class, 'storePeminjaman']);
Route::post('/pengembalian/store', [PengembalianController::class, 'storePengembalian']);
Route::post('/petugas/store', [PetugasController::class, 'storePetugas']);
Route::post('/rak/store', [RakController::class, 'storeRak']);