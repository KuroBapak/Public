<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $petugass = Db::table('petugas')->get();
        return view('petugas.index', compact('petugass'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'telp' => 'required|numeric|min:10',
            'alamat' => 'required|min:10',
        ],[
            'nama.required' => 'nama wajib diisi, tidak boleh kosong ya cuy',
            'jabatan.required' => 'jabatan wajib diisi, tidak boleh kosong ya cuy',
            'telp.required' => 'telp wajib diisi, tidak boleh kosong ya cuy',
            'telp.numeric' => 'telp harus berupa angka',
            'telp.min' => 'telp minimal 10 angka',
            'alamat.required' => 'alamat wajib diisi, tidak boleh kosong ya cuy',
            'alamat.min' => 'alamat minimal 10 angka',

        ]);

        $query = DB::table('petugas')->insert([
            'nama_petugas' => $request['nama'],
            'jabatan_petugas' => $request['jabatan'],
            'no_telp_petugas' => $request['telp'],
            'alamat_petugas' => $request['alamat'],
        ]);

        return redirect()->route('petugas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $petugass = DB::table('petugas')->where('id', $id)->get();
        return view('petugas.show', compact('petugass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $petugass = DB::table('petugas')->where('id', $id)->get();
        return view('petugas.edit', compact('petugass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'telp' => 'required|numeric|min:10',
            'alamat' => 'required|min:10',
        ]);

        $query = DB::table('petugas')->where('id', $id)->update([
            'nama_petugas' => $request['nama'],
            'jabatan_petugas' => $request['jabatan'],
            'no_telp_petugas' => $request['telp'],
            'alamat_petugas' => $request['alamat'],
        ]);
        return redirect()->route('petugas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $petugass = DB::table('petugas')->where('id', $id)->delete();
        return redirect()->route('petugas.index');
    }
}