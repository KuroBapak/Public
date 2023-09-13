<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Petugas;
use App\Models\Rak;
use Illuminate\Http\Request;

class MasterController extends Controller
{

    public function content(){
        $buku = Buku::all();
        $anggota = Anggota::all();
        $peminjaman = Peminjaman::all();
        $pengembalian = Pengembalian::all();
        $petugas = Petugas::all();
        $rak = Rak::all();
        return view('content',compact(['buku','anggota','peminjaman','pengembalian','petugas','rak']));
        //dd($buku);
    }

    public function master(){
        return view('template.master');
    }

}