@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('petugas.update', $petugass[0]->id_petugas )}}" method="POST">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Petugas</label>
                  <input type="text" class="form-control @error('nama_petugas') is-invalid @enderror" name="nama_petugas" value="{{ $petugass[0]->nama_petugas}}" placeholder="{{ $petugass[0]->nama_petugas}}">
                  @error('nama_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Jabatan Petugas</label>
                  <input type="text" class="form-control @error('jabatan_petugas') is-invalid @enderror" name="jabatan_petugas" value="{{ $petugass[0]->jabatan_petugas}}" placeholder="{{ $petugass[0]->jabatan_petugas}}">
                  @error('jabatan_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">No Telepon</label>
                  <input type="number" class="form-control @error('no_telp_petugas') is-invalid @enderror" name="no_telp_petugas" value="{{ $petugass[0]->no_telp_petugas}}" placeholder="{{ $petugass[0]->no_telp_petugas}}">
                  @error('no_telp_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Alamat Petugas</label>
                  <input type="text" class="form-control @error('alamat_petugas') is-invalid @enderror" name="alamat_petugas" value="{{ $petugass[0]->alamat_petugas}}" placeholder="{{ $petugass[0]->alamat_petugas}}">
                  @error('alamat_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('{{ __('Are You Sure Want To Edit?') }}')">
                  {{ __('Edit') }}
                </button>
                <button type="reset" class="btn btn-primary">Reset</button>
              </div>
            </form>
          </div>
</div>
@endsection