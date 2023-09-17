@extends('template.master')

@section('content')
<div class="card-body">
    <div class="form-group">
      <label for="exampleInputEmail1">Kode Anggota</label>
      <input disabled type="text" class="form-control" name="kode_anggota" value="{{ $anggotas[0]->kode_anggota}}" >
      <label for="exampleInputEmail1">Nama Anggota</label>
      <input disabled type="text" class="form-control" name="nama_anggota" value="{{ $anggotas[0]->nama_anggota}}" >
          <label>Jenis Kelamin</label>
          <select disabled type="text" name="jk_anggota" class="form-control">
            <option disabled>Pilih Jenis Kelamin</option>
            <option value="L">Laki-Laki</option>
            <option value="P">Perempuan</option>
          </select>
      <label for="exampleInputEmail1">Jurusan anggota</label>
      <input disabled type="text" class="form-control " name="jurusan_anggota" value="{{ $anggotas[0]->jurusan_anggota}}">
      <label for="exampleInputEmail1">No Telepon</label>
      <input disabled type="number" class="form-control " name="no_telp_anggota" value="{{ $anggotas[0]->no_telp_anggota}}">
      <label for="exampleInputEmail1">Alamat Anggota</label>
      <input disabled type="text" class="form-control" name="alamat_anggota" value="{{ $anggotas[0]->alamat_anggota}}">
    </div>
</div>
@endsection