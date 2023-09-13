<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class PetugasController extends Controller
{
    public function content(){
        $petugas = Petugas::all();
        return view('content',compact(['petugas']));
        //dd($buku);
    }

    public function storePetugas(Request $tb_petugas){
        //dd($tb_buku->except(['_token','submit']));
        Petugas::create($tb_petugas->except(['_token','submit']));
    }

    public function petugas(){
        return view('petugas');
    }
}