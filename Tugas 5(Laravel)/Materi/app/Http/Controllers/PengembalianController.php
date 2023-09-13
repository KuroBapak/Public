<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;


class PengembalianController extends Controller
{
    public function content(){
        $pengembalian = Pengembalian::all();
        return view('content',compact(['pengembalian']));
        //dd($buku);
    }

    public function storePengembalian(Request $tb_pengembalian){
        //dd($tb_buku->except(['_token','submit']));
        Pengembalian::create($tb_pengembalian->except(['_token','submit']));
    }

    public function pengembalian(){
        return view('pengembalian');
    }
}