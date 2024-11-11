<?php

use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/bacatemp', [SensorController::class, 'ftemp']);
Route::get('/bacapress', [SensorController::class, 'fpress']);
Route::get('/bacalight', [SensorController::class, 'flight']);
Route::get('/bacaavgt', [SensorController::class, 'favgt']);
Route::get('/bacaavgs', [SensorController::class, 'favgs']);
Route::get('/nilai/{simpannilaitemp}/{simpannilaipress}/{simpannilailight}', [SensorController::class, 'SimpanNilai']);
Route::get('/nilaiavg/{simpannilaiavgt}/{simpannilaiavgs}', [SensorController::class, 'SimpanNilaiAvg']);
