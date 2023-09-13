<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;


class AnggotaController extends Controller
{
    public function content(){
        $anggota = Anggota::all();
        return view('content',compact(['anggota']));
        //dd($buku);
    }

    public function storeAnggota(Request $tb_anggota){
        //dd($tb_buku->except(['_token','submit']));
        Anggota::create($tb_anggota->except(['_token','submit']));
    }

    public function anggota(){
        return view('anggota');
    }
}