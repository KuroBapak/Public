@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('anggota.update', $anggotas[0]->id_anggota )}}" method="POST">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Anggota</label>
                  <input type="text" class="form-control @error('kode_anggota') is-invalid @enderror" name="kode_anggota" value="{{ $anggotas[0]->kode_anggota}}" placeholder="{{ $anggotas[0]->kode_anggota}}">
                  @error('kode_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Nama Anggota</label>
                  <input type="text" class="form-control @error('nama_anggota') is-invalid @enderror" name="nama_anggota" value="{{ $anggotas[0]->nama_anggota}}" placeholder="{{ $anggotas[0]->nama_anggota}}">
                  @error('nama_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label>Jenis Kelamin</label>
                      <select type="text" name="jk_anggota" class="form-control @error('jk_anggota') is-invalid @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                      @error('jk_anggota')
                      <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  <label for="exampleInputEmail1">Jurusan anggota</label>
                  <input type="text" class="form-control @error('jurusan_anggota') is-invalid @enderror" name="jurusan_anggota" value="{{ $anggotas[0]->jurusan_anggota}}" placeholder="{{ $anggotas[0]->jurusan_anggota}}">
                  @error('jurusan_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">No Telepon</label>
                  <input type="number" class="form-control @error('no_telp_anggota') is-invalid @enderror" name="no_telp_anggota" value="{{ $anggotas[0]->no_telp_anggota}}" placeholder="{{ $anggotas[0]->no_telp_anggota}}">
                  @error('no_telp_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Alamat Anggota</label>
                  <input type="text" class="form-control @error('alamat_anggota') is-invalid @enderror" name="alamat_anggota" value="{{ $anggotas[0]->alamat_anggota}}" placeholder="{{ $anggotas[0]->alamat_anggota}}">
                  @error('alamat_anggota')
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