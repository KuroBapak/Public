<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'kode' => 'required||unique:bukus,kode_buku|min:3',
            'judul' => 'required|min:5',
            'penulis' => 'required|min:5',
            'penerbit' => 'required|min:5',
            'tahun' => 'required',
            'stok' => 'required',
        ],[
            'kode.required' => 'kode wajib diisi, tidak boleh kosong ya cuy',
            'kode.unique' => 'Kode sudah terdaftar, silahkan coba dengan kode lain',
            'kode.min' => 'kode minimal 3 angka',
            'judul.required' => 'judul wajib diisi, tidak boleh kosong ya cuy',
            'judul.min' => 'judul minimal 5 huruf',
            'penulis.required' => 'penulis wajib diisi, tidak boleh kosong ya cuy',
            'penulis.min' => 'penulis minimal 5 huruf',
            'penerbit.required' => 'penerbit wajib diisi, tidak boleh kosong ya cuy',
            'penerbit.min' => 'penerbit minimal 5 huruf',
            'tahun.required' => 'tahun wajib diisi, tidak boleh kosong ya cuy',
            'stok.required' => 'stok wajib diisi, tidak boleh kosong ya cuy',

        ]);
        $query = DB::table('bukus')->insert([
            'kode_buku' => $request['kode'],
            'judul_buku' => $request['judul'],
            'penulis_buku' => $request['penulis'],
            'penerbit_buku' => $request['penerbit'],
            'tahun_penerbit' => $request['tahun'],
            'stok' => $request['stok'],
        ]);

        return redirect()->route('buku.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $bukus, $id)
    {
        //
        $bukus = Buku::findOrFail($id);
        return view('buku.show', compact('bukus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $bukus = Buku::find($id);
        return view('buku.edit', compact('bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'kode' => 'required||min:3',
            'judul' => 'required|min:5',
            'penulis' => 'required|min:5',
            'penerbit' => 'required|min:5',
            'tahun' => 'required',
            'stok' => 'required',
        ],[
            'kode.required' => 'kode wajib diisi, tidak boleh kosong ya cuy',
            'kode.min' => 'kode minimal 3 angka',
            'judul.required' => 'judul wajib diisi, tidak boleh kosong ya cuy',
            'judul.min' => 'judul minimal 5 huruf',
            'penulis.required' => 'penulis wajib diisi, tidak boleh kosong ya cuy',
            'penulis.min' => 'penulis minimal 5 huruf',
            'penerbit.required' => 'penerbit wajib diisi, tidak boleh kosong ya cuy',
            'penerbit.min' => 'penerbit minimal 5 huruf',
            'tahun.required' => 'tahun wajib diisi, tidak boleh kosong ya cuy',
            'stok.required' => 'stok wajib diisi, tidak boleh kosong ya cuy',

        ]);
        $query = DB::table('bukus')->where('id', $id)->update([
            'kode_buku' => $request['kode'],
            'judul_buku' => $request['judul'],
            'penulis_buku' => $request['penulis'],
            'penerbit_buku' => $request['penerbit'],
            'tahun_penerbit' => $request['tahun'],
            'stok' => $request['stok'],
        ]);
        return redirect()->route('buku.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $bukus = DB::table('bukus')->where('id', $id)->delete();
        return redirect()->route('buku.index');
    }
}