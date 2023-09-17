@extends('template.master')

@section('content')
<div class="card-body">
  <div class="form-group">
    <label for="exampleInputEmail1">Nama Petugas</label>
    <input disabled type="text" class="form-control" name="nama_petugas" value="{{ $petugass[0]->nama_petugas}}">
    <label for="exampleInputEmail1">Jabatan Petugas</label>
    <input disabled type="text" class="form-control" name="jabatan_petugas" value="{{ $petugass[0]->jabatan_petugas}}">
    <label for="exampleInputEmail1">No Telepon</label>
    <input disabled type="number" class="form-control" name="no_telp_petugas" value="{{ $petugass[0]->no_telp_petugas}}">
    <label for="exampleInputEmail1">Alamat Petugas</label>
    <input disabled type="text" class="form-control" name="alamat_petugas" value="{{ $petugass[0]->alamat_petugas}}">
  </div>
</div>
@endsection