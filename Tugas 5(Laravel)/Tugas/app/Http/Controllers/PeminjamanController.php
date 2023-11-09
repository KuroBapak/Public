<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Petugas;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $peminjamans = Peminjaman::all();
        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Buku $buku, Anggota $anggota, Petugas $petugas)
    {
        //
        $bukus = $buku->all();
        $anggotas = $anggota->all();
        $petugass = $petugas->all();
        return view('peminjaman.create', compact('bukus','anggotas','petugass'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        //
        $request->validate([
            'pinjam' => 'required',
            'kembali' => 'required',
            'buku' => 'required',
            'anggota' => 'required',
            'petugas' => 'required',
        ],[
            'pinjam.required' => 'Tanggal Pinjam wajib diisi, tidak boleh kosong ya cuy',
            'kembali.required' => 'Tanggal Kembali wajib diisi, tidak boleh kosong ya cuy',
            'buku.required' => 'buku wajib diisi, tidak boleh kosong ya cuy',
            'anggota.required' => 'anggota wajib diisi, tidak boleh kosong ya cuy',
            'petugas.required' => 'petugas wajib diisi, tidak boleh kosong ya cuy',
        ]);

        $peminjaman::create([
            'tanggal_pinjam' => $request['pinjam'],
            'tanggal_kembali' => $request['kembali'],
            'id_buku' => $request['buku'],
            'id_anggota' => $request['anggota'],
            'id_petugas' => $request['petugas'],
        ]);
        return redirect()->route('peminjaman.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $peminjaman = Peminjaman::findOrFail($id);
        $bukus = Buku::find($peminjaman->id_buku); // Mengambil buku berdasarkan ID tertentu
        $anggotas = Anggota::find($peminjaman->id_anggota); // Mengambil buku berdasarkan ID tertentu
        $petugass = Petugas::find($peminjaman->id_petugas); // Mengambil buku berdasarkan ID tertentu
        return view('peminjaman.show', compact('peminjaman','bukus','anggotas','petugass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        // Ambil data peminjaman yang akan diedit
        $peminjaman = Peminjaman::find($id);
    
        // Ambil semua data buku,anggota,petugas untuk dropdown
        $bukus = Buku::all();
        $anggotas = Anggota::all();
        $petugass = Petugas::all();
    
        return view('peminjaman.edit', compact('bukus','anggotas','petugass','peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
        $request->validate([
            'pinjam' => 'required',
            'kembali' => 'required',
            'buku' => 'required',
            'anggota' => 'required',
            'petugas' => 'required',
        ],[
            'pinjam.required' => 'Tanggal Pinjam wajib diisi, tidak boleh kosong ya cuy',
            'kembali.required' => 'Tanggal Kembali wajib diisi, tidak boleh kosong ya cuy',
            'buku.required' => 'buku wajib diisi, tidak boleh kosong ya cuy',
            'anggota.required' => 'anggota wajib diisi, tidak boleh kosong ya cuy',
            'petugas.required' => 'petugas wajib diisi, tidak boleh kosong ya cuy',
        ]);

        $peminjaman->update([
            'tanggal_pinjam' => $request['pinjam'],
            'tanggal_kembali' => $request['kembali'],
            'id_buku' => $request['buku'],
            'id_anggota' => $request['anggota'],
            'id_petugas' => $request['petugas'],
        ]);        
        
        return redirect()->route('peminjaman.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
        $peminjaman->delete();
        return redirect()->route('peminjaman.index');
    }
}