<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PetugasController;
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
Route::get('/petugas', [PetugasController::class, 'petugas'])->name('petugas');
Route::post('/buku/store', [BukuController::class, 'storeb']);
Route::post('/anggota/store', [AnggotaController::class, 'storea']);
Route::post('/petugas/store', [PetugasController::class, 'storep']);

