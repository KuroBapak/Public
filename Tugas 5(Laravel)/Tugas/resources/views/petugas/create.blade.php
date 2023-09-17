@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('petugas.store')}}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Petugas</label>
                  <input type="text" class="form-control @error('nama_petugas') is-invalid @enderror" name="nama_petugas" placeholder="Input Nama Petugas">
                  @error('nama_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Jabatan Petugas</label>
                  <input type="text" class="form-control @error('jabatan_petugas') is-invalid @enderror" name="jabatan_petugas" placeholder="Input Jabatan Petugas">
                  @error('jabatan_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">No Telepon</label>
                  <input type="number" class="form-control @error('no_telp_petugas') is-invalid @enderror" name="no_telp_petugas" placeholder="Input No Telepon Petugas">
                  @error('no_telp_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Alamat Petugas</label>
                  <input type="text" class="form-control @error('alamat_petugas') is-invalid @enderror" name="alamat_petugas" placeholder="Input Alamat Petugas">
                  @error('alamat_petugas')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
              </div>
            </form>
          </div>
</div>
@endsection