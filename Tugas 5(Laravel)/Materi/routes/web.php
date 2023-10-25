<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;

use App\Http\Controllers\ImageController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\PeranController;

Route::resource('images', ImageController::class);

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/form', function () {
//     return view('form');
// })->name('form');

// Route::get('/welcome', function () {
//     return view('welcometest');
// })->name('welcome');

// Route::get('index', function () {
//     return view('index');
// });

Route::controller(AuthController::class)->group(function() {
    Route::get('/registration', 'register')->name('auth.register');
    Route::post('/store', 'store')->name('auth.store');
    Route::get('/login', 'login')->name('auth.login');
    Route::post('/auth', 'authentication')->name('auth.authentication');
    Route::get('/dashboard', 'dashboard')->name('auth.dashboard');
    Route::post('/logout', 'logout')->name('auth.logout');
});

Route::get('/', [AuthorController::class, 'index']);
Route::get('/form', [AuthorController::class, 'form'])->name('form');
Route::get('/welcome', [AuthorController::class, 'welcome'])->name('welcome');

Route::get('/index', function() {
    return view('template.master');
});

Route::resource('/film', FilmController::class)->Middleware('auth');
Route::resource('/cast', CastController::class)->middleware('auth');
Route::resource('/genre', GenreController::class)->middleware('auth');

Route::get('/film/{id}/peran/create', [PeranController::class,'create'])->name('peran.create');
Route::post('film/{id}/peran', [PeranController::class, 'store'])->name('peran.store');
Route::get('/film/{id}/kritik/create', [KritikController::class,'create'])->name('kritik.create');
Route::post('/film/{id}/kritik', [KritikController::class, 'store'])->name('kritik.store');