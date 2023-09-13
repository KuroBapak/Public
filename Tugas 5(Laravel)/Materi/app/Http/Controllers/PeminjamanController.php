<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;


class PeminjamanController extends Controller
{
    public function content(){
        $peminjaman = Peminjaman::all();
        return view('content',compact(['peminjaman']));
        //dd($buku);
    }

    public function storePeminjaman(Request $tb_peminjaman){
        //dd($tb_buku->except(['_token','submit']));
        Peminjaman::create($tb_peminjaman->except(['_token','submit']));
    }

    public function peminjaman(){
        return view('peminjaman');
    }
}