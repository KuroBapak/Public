@extends('template.master')

@section('content')
<div class="card-body">
    <div class="form-group">
      <label for="exampleInputEmail1">Kode Buku</label>
      <input disabled type="number" class="form-control" name="kode_buku" value="{{ $bukus[0]->kode_buku}}">
      <label for="exampleInputEmail1">Judul Buku</label>
      <input disabled type="text" class="form-control" name="judul_buku" value="{{ $bukus[0]->judul_buku}}">
      <label for="exampleInputEmail1">Penulis Buku</label>
      <input disabled type="text" class="form-control" name="penulis_buku" value="{{ $bukus[0]->penulis_buku}}">
      <label for="exampleInputEmail1">Penerbit Buku</label>
      <input disabled type="text" class="form-control" name="penerbit_buku" value="{{ $bukus[0]->penerbit_buku}}">
      <label for="exampleInputEmail1">Tahun Penerbitan</label>
      <input disabled type="number" class="form-control" name="tahun_penerbit" value="{{ $bukus[0]->tahun_penerbit}}">
      <label for="exampleInputEmail1">Stok Buku</label>
      <input disabled type="number" class="form-control" name="stok" value="{{ $bukus[0]->stok}}">
    </div>
  </div>
@endsection