<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;


class RakController extends Controller
{
    public function content(){
        $rak = Rak::all();
        return view('content',compact(['rak']));
        //dd($buku);
    }

    public function storeRak(Request $tb_rak){
        //dd($tb_buku->except(['_token','submit']));
        Rak::create($tb_rak->except(['_token','submit']));
    }

    public function rak(){
        return view('rak');
    }
}