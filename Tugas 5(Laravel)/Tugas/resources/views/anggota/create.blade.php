@extends('template.master')

@section('content')

<div class="content-wrapper">
<div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Form Input Data Anggota</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
              <div class="card-body">
              <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Data Anggota</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Kode Anggota</label>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="Input Kode Anggota" value="{{ old('kode') }}">
                    @error('kode')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Nama Anggota</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Input Nama Anggota" value="{{ old('nama') }}">
                    @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Jenis Kelamin</label>
                    <select type="text" name="jk" class="form-control @error('jk') is-invalid @enderror" value="{{ old('jk') }}">
                        <option disabled selectdes>Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('jk')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Jurusan</label>
                      <select type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan') }}">
                        <option disabled selectdes>Jurusan</option>
                        <option value="RPL">RPL</option>
                        <option value="TKJ">TKJ</option>
                        <option value="DPIB">DPIB</option>
                        <option value="DGM">DGM</option>
                        <option value="TM">TM</option>
                        <option value="TKRO">TKRO</option>
                        <option value="TBSM">TBSM</option>
                        <option value="TEI">TEI</option>
                        <option value="TITL">TITL</option>
                        <option value="TFLM">TFLM</option>
                        <option value="TPL">TPL</option>
                      </select>
                      @error('jurusan')
                            <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    <label for="exampleInputEmail1">No Telepon</label>
                    <input type="number" class="form-control @error('telp') is-invalid @enderror" name="telp" placeholder="Input No Telp Anggota" value="{{ old('telp') }}">
                    @error('telp')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Alamat Anggota</label>
                    <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Input Alamat Anggota" cols="30" rows="10" value="{{ old('alamat') }}"></textarea>
                    @error('alamat')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <a href="" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Kembali</a>
                </div>
              </form>
            </div>
            </div>

             <div class="modal" tabindex="-1" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Peringatan</h5>
                  </div>
                  <div class="modal-body">
                    <p>Apakah Anda Yakin Akan Keluar Dari Form Create Data Anggota</p>
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-success">Yes</a>
                  </div>
                </div>
              </div>
            </div>

<!-- jQuery -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
@endsection