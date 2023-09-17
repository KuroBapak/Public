@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('anggota.store')}}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Anggota</label>
                  <input type="text" class="form-control @error('kode_anggota') is-invalid @enderror" name="kode_anggota" placeholder="Input Kode Anggota">
                  @error('kode_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Nama Anggota</label>
                  <input type="text" class="form-control @error('nama_anggota') is-invalid @enderror" name="nama_anggota" placeholder="Input Nama Anggota">
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
                  <input type="text" class="form-control @error('jurusan_anggota') is-invalid @enderror" name="jurusan_anggota" placeholder="Input Jurusan Anggota">
                  @error('jurusan_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">No Telepon</label>
                  <input type="number" class="form-control @error('no_telp_anggota') is-invalid @enderror" name="no_telp_anggota" placeholder="Input No Telp Anggota">
                  @error('no_telp_anggota')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <label for="exampleInputEmail1">Alamat Anggota</label>
                  <input type="text" class="form-control @error('alamat_anggota') is-invalid @enderror" name="alamat_anggota" placeholder="Input Alamat Anggota">
                  @error('alamat_anggota')
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