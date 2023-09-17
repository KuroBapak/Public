@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('buku.store')}}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Buku</label>
                  <input type="number" class="form-control @error('kode_buku') is-invalid @enderror" name="kode_buku" placeholder="Input Kode Buku">
                  @error('kode_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Judul Buku</label>
                  <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" name="judul_buku" placeholder="Input Judul Buku">
                  @error('judul_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Penulis Buku</label>
                  <input type="text" class="form-control @error('penulis_buku') is-invalid @enderror" name="penulis_buku" placeholder="Input Penulis Buku">
                  @error('penulis_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Penerbit Buku</label>
                  <input type="text" class="form-control @error('penerbit_buku') is-invalid @enderror" name="penerbit_buku" placeholder="Input Penerbit Buku">
                  @error('penerbit_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Tahun Penerbitan</label>
                  <input type="number" class="form-control @error('tahun_penerbit') is-invalid @enderror" name="tahun_penerbit" placeholder="Input Tahun Penerbitan">
                  @error('tahun_penerbit')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Stok Buku</label>
                  <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" placeholder="Input Sisa Stock">
                  @error('stok')
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