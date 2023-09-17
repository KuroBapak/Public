@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('buku.update', $bukus[0]->id_buku )}}" method="POST">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Buku</label>
                  <input type="number" class="form-control @error('kode_buku') is-invalid @enderror" name="kode_buku" value="{{ $bukus[0]->kode_buku}}" placeholder="{{ $bukus[0]->kode_buku}}">
                  @error('kode_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Judul Buku</label>
                  <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" name="judul_buku" value="{{ $bukus[0]->judul_buku}}" placeholder="{{ $bukus[0]->judul_buku}}">
                  @error('judul_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Penulis Buku</label>
                  <input type="text" class="form-control @error('penulis_buku') is-invalid @enderror" name="penulis_buku" value="{{ $bukus[0]->penulis_buku}}" placeholder="{{ $bukus[0]->penulis_buku}}">
                  @error('penulis_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Penerbit Buku</label>
                  <input type="text" class="form-control @error('penerbit_buku') is-invalid @enderror" name="penerbit_buku" value="{{ $bukus[0]->penerbit_buku}}" placeholder="{{ $bukus[0]->penerbit_buku}}">
                  @error('penerbit_buku')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Tahun Penerbitan</label>
                  <input type="number" class="form-control @error('tahun_penerbit') is-invalid @enderror" name="tahun_penerbit" value="{{ $bukus[0]->tahun_penerbit}}" placeholder="{{ $bukus[0]->tahun_penerbit}}">
                  @error('tahun_penerbit')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Stok Buku</label>
                  <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ $bukus[0]->stok}}" placeholder="{{ $bukus[0]->stok}}">
                  @error('stok')
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