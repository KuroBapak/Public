<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $anggotas = Anggota::all();
        return view('anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:anggotas,kode_anggota', // Validasi agar 'kode' unik
            'nama' => 'required|unique:anggotas,nama_anggota|min:3',
            'jk' => 'required',
            'jurusan' => 'required',
            'telp' => 'required|numeric|min:10',
            'alamat' => 'required|min:10',
        ], [
            'kode.required' => 'Kode wajib diisi, tidak boleh kosong ya cuy',
            'kode.unique' => 'Kode sudah terdaftar, silahkan coba dengan kode lain',
            'nama.required' => 'Nama wajib diisi, tidak boleh kosong ya cuy',
            'nama.unique' => 'Nama sudah terdaftar, silahkan coba dengan nama lain',
            'nama.min' => 'Nama minimal 3 huruf',
            'jk.required' => 'Jenis kelamin wajib diisi, tidak boleh kosong ya cuy',
            'jurusan.required' => 'Jurusan wajib diisi, tidak boleh kosong ya cuy',
            'telp.required' => 'Telp wajib diisi, tidak boleh kosong ya cuy',
            'telp.numeric' => 'Telp harus berupa angka',
            'telp.min' => 'Telp minimal 10 angka',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.min' => 'Alamat minimal 10 huruf',
        ]);

        // Pastikan Anda mengisi 'kode_anggota' dengan nilai yang unik
        // Contoh mengambil nilai dari input 'kode' dalam permintaan
        $kodeAnggota = $request->input('kode');

        // Selanjutnya, Anda bisa membuat objek Anggota baru dengan 'kode_anggota' yang sesuai
        Anggota::create([
            'kode_anggota' => $kodeAnggota,
            'nama_anggota' => $request->input('nama'),
            'jk_anggota' => $request->input('jk'),
            'jurusan_anggota' => $request->input('jurusan'),
            'no_telp_anggota' => $request->input('telp'),
            'alamat_anggota' => $request->input('alamat'),
        ]);

        return redirect()->route('anggota.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota, $id)
    {
        // Menggunakan parameter $id untuk mengambil data anggota dari database
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota, string $id)
    {
        //
        $anggota = Anggota::find($id);
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode' => 'required', // Validasi agar 'kode' unik
            'nama' => 'required|min:3',
            'jk' => 'required',
            'jurusan' => 'required',
            'telp' => 'required|numeric|min:10',
            'alamat' => 'required|min:10',
        ], [
            'kode.required' => 'Kode wajib diisi, tidak boleh kosong ya cuy',
            'nama.required' => 'Nama wajib diisi, tidak boleh kosong ya cuy',
            'nama.min' => 'Nama minimal 3 huruf',
            'jk.required' => 'Jenis kelamin wajib diisi, tidak boleh kosong ya cuy',
            'jurusan.required' => 'Jurusan wajib diisi, tidak boleh kosong ya cuy',
            'telp.required' => 'Telp wajib diisi, tidak boleh kosong ya cuy',
            'telp.numeric' => 'Telp harus berupa angka',
            'telp.min' => 'Telp minimal 10 angka',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.min' => 'Alamat minimal 10 huruf',
        ]);

        // Temukan anggota yang ingin diperbarui
        $anggota = Anggota::find($id);

        // Atur nilai-nilai yang ingin diperbarui
        $anggota->update([
            'kode_anggota' => $request->input('kode'),
            'nama_anggota' => $request->input('nama'),
            'jk_anggota' => $request->input('jk'), // Perhatikan penamaan ini
            'jurusan_anggota' => $request->input('jurusan'), // Perhatikan penamaan ini
            'no_telp_anggota' => $request->input('telp'),
            'alamat_anggota' => $request->input('alamat'),
        ]);

        return redirect()->route('anggota.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $query = DB::table('anggotas')->where('id', $id)->delete();
        return redirect()->route('anggota.index');
    }
    
}