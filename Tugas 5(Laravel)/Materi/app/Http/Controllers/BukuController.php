<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function content(){
        $buku = Buku::all();
        return view('content',compact(['buku']));
        //dd($buku);
    }

    public function storeBuku(Request $tb_buku){
        //dd($tb_buku->except(['_token','submit']));
        Buku::create($tb_buku->except(['_token','submit']));
    }

    public function buku(){
        return view('buku');
    }
}