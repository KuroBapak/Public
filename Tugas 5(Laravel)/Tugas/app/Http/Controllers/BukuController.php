<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = DB::table('buku')->get();
        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|numeric',
            'judul_buku' => 'required',
            'penulis_buku' => 'required',
            'penerbit_buku' => 'required',
            'tahun_penerbit' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $query = DB::table('buku')->insert([
            'kode_buku' => $request['kode_buku'],
            'judul_buku' => $request['judul_buku'],
            'penulis_buku' => $request['penulis_buku'],
            'penerbit_buku' => $request['penerbit_buku'],
            'tahun_penerbit' => $request['tahun_penerbit'],
            'stok' => $request['stok']
        ]);
        return redirect()->route('buku.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bukus = DB::table('buku')->where('id_buku', $id)->get();
        return view('buku.show', compact('bukus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bukus = DB::table('buku')->where('id_buku', $id)->get();
        return view('buku.edit', compact('bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_buku' => 'required|numeric',
            'judul_buku' => 'required',
            'penulis_buku' => 'required',
            'penerbit_buku' => 'required',
            'tahun_penerbit' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $query = DB::table('buku')->where('id_buku',$id)->update([
            'kode_buku' => $request['kode_buku'],
            'judul_buku' => $request['judul_buku'],
            'penulis_buku' => $request['penulis_buku'],
            'penerbit_buku' => $request['penerbit_buku'],
            'tahun_penerbit' => $request['tahun_penerbit'],
            'stok' => $request['stok']
        ]);
        return redirect()->route('buku.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $query = DB::table('buku')->where('id_buku',$id)->delete();
        return redirect()->route('buku.index');
    }
}
