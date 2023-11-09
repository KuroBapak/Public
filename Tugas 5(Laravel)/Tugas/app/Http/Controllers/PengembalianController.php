<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Petugas;
use App\Models\Anggota;


class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pengembalians = Pengembalian::all();
        return view('pengembalian.index', compact('pengembalians'));
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
        return view('pengembalian.create', compact('bukus','anggotas','petugass'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pengembalian $pengembalian)
    {
        //
        $request->validate([
            'pengembalian' => 'required',
            'buku' => 'required',
            'anggota' => 'required',
            'petugas' => 'required',
        ],[
            'pengembalian.required' => 'Tanggal Pengembalian wajib diisi, tidak boleh kosong ya cuy',
            'buku.required' => 'buku wajib diisi, tidak boleh kosong ya cuy',
            'anggota.required' => 'anggota wajib diisi, tidak boleh kosong ya cuy',
            'petugas.required' => 'petugas wajib diisi, tidak boleh kosong ya cuy',
        ]);

        $pengembalian::create([
            'tanggal_pengembalian' => $request['pengembalian'],
            'denda' => $request['denda'],
            'id_buku' => $request['buku'],
            'id_anggota' => $request['anggota'],
            'id_petugas' => $request['petugas'],
        ]);
        return redirect()->route('pengembalian.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $pengembalian = Pengembalian::findOrFail($id);
        $bukus = Buku::find($pengembalian->id_buku); // Mengambil buku berdasarkan ID tertentu
        $anggotas = Anggota::find($pengembalian->id_anggota); // Mengambil buku berdasarkan ID tertentu
        $petugass = Petugas::find($pengembalian->id_petugas); // Mengambil buku berdasarkan ID tertentu
        return view('pengembalian.show', compact('pengembalian','bukus','anggotas','petugass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        // Ambil data pengembalian yang akan diedit
        $pengembalian = Pengembalian::find($id);

        // Ambil semua data buku,anggota,petugas untuk dropdown
        $bukus = Buku::all();
        $anggotas = Anggota::all();
        $petugass = Petugas::all();

        return view('pengembalian.edit', compact('bukus','anggotas','petugass','pengembalian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        //
        $request->validate([
            'pengembalian' => 'required',
            'buku' => 'required',
            'denda' => 'required|numeric',
            'anggota' => 'required',
            'petugas' => 'required',
        ],[
            'pengembalian.required' => 'Tanggal Pengembalian wajib diisi, tidak boleh kosong ya cuy',
            'buku.required' => 'buku wajib diisi, tidak boleh kosong ya cuy',
            'denda.required' => 'denda wajib diisi, tidak boleh kosong ya cuy',
            'denda.numeric' => 'denda wajib berupa angka ya cuy',
            'anggota.required' => 'anggota wajib diisi, tidak boleh kosong ya cuy',
            'petugas.required' => 'petugas wajib diisi, tidak boleh kosong ya cuy',
        ]);

        $pengembalian->update([
            'tanggal_pengembalian' => $request['pengembalian'],
            'denda' => $request['denda'],
            'id_buku' => $request['buku'],
            'id_anggota' => $request['anggota'],
            'id_petugas' => $request['petugas'],
        ]);
        return redirect()->route('pengembalian.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
        $pengembalian->delete();
        return redirect()->route('pengembalian.index');
    }
}