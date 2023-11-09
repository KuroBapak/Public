<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Buku;
use Illuminate\Http\Request;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $raks = Rak::all();
        return view('rak.index', compact('raks'));
    }

    /**
     * Show the form for creating a new resource.
     */ 
    public function create(Buku $buku)
    {
        $bukus = $buku->all();
        return view('rak.create', compact('bukus'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Rak $rak)
    {
        //
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'buku' => 'required',
        ],[
            'nama.required' => 'nama wajib diisi, tidak boleh kosong ya cuy',
            'lokasi.required' => 'lokasi wajib diisi, tidak boleh kosong ya cuy',
            'buku.required' => 'buku wajib diisi, tidak boleh kosong ya cuy',
        ]);

        $rak::create([
            'nama_rak' => $request['nama'],
            'lokasi_rak' => $request['lokasi'],
            'id_buku' => $request['buku'],
        ]);
        return redirect()->route('rak.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $rak = Rak::findOrFail($id);
        $buku = Buku::find($rak->id_buku); // Mengambil buku berdasarkan ID tertentu
        return view('rak.show', compact('rak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data rak yang akan diedit
        $rak = Rak::find($id);
    
        // Ambil semua data buku untuk dropdown
        $buku = Buku::all();
    
        return view('rak.edit', compact('rak', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rak $rak)
    {
        //
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'buku' => 'required',
        ],[
            'nama.required' => 'nama wajib diisi, tidak boleh kosong ya cuy',
            'lokasi.required' => 'lokasi wajib diisi, tidak boleh kosong ya cuy',
            'buku.required' => 'buku wajib diisi, tidak boleh kosong ya cuy',
        ]);

        $rak->update([
            'nama_rak' => $request['nama'],
            'lokasi_rak' => $request['lokasi'],
            'id_buku' => $request['buku'],
        ]);
        return redirect()->route('rak.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rak $rak)
    {
        //
        $rak->delete();
        return redirect()->route('rak.index');
    }
}