@extends('template.master')

@section('content')
    <div class="content-wrapper">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Detail Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Data Anggota</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kode Anggota</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    name="kode" value="{{ $anggota->kode_anggota }}">
                                @error('kode')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="exampleInputEmail1">Nama Anggota</label>
                                <input type="text" class="form-control  @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ $anggota->nama_anggota }}">
                                @error('nama')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select name="jk" id="jk"
                                        class="form-control @error('jk') is-invalid @enderror"
                                        value="{{ $anggota->jk_anggota }}">
                                        <option value="L" @if ($anggota->jk == 'L') selected @endif>Laki-Laki
                                        </option>
                                        <option value="P" @if ($anggota->jk == 'P') selected @endif>Perempuan
                                        </option>
                                    </select>
                                </div>
                                @error('jk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Jurusan</label>
                                <select type="text" name="jurusan"
                                    class="form-control @error('jurusan') is-invalid @enderror"
                                    value="{{ $anggota->jurusan_anggota }}">
                                    <option selectdes>Jurusan</option>
                                    <option value="RPL" @if ($anggota->jurusan_anggota == 'RPL') selected @endif>RPL</option>
                                    <option value="TKJ"@if ($anggota->jurusan_anggota == 'TKJ') selected @endif>TKJ</option>
                                    <option value="DPIB" @if ($anggota->jurusan_anggota == 'DPIB') selected @endif>DPIB</option>
                                    <option value="DGM" @if ($anggota->jurusan_anggota == 'DGM') selected @endif>DGM</option>
                                    <option value="TM" @if ($anggota->jurusan_anggota == 'TM') selected @endif>TM</option>
                                    <option value="TKRO" @if ($anggota->jurusan_anggota == 'TKRO') selected @endif>TKRO</option>
                                    <option value="TBSM" @if ($anggota->jurusan_anggota == 'TBSM') selected @endif>TBSM</option>
                                    <option value="TEI" @if ($anggota->jurusan_anggota == 'TEI') selected @endif>TEI</option>
                                    <option value="TITL" @if ($anggota->jurusan_anggota == 'TITL') selected @endif>TITL</option>
                                    <option value="TFLM" @if ($anggota->jurusan_anggota == 'TFLM') selected @endif>TFLM</option>
                                    <option value="TPL" @if ($anggota->jurusan_anggota == 'TPL') selected @endif>TPL</option>
                                </select>
                                @error('jurusan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="exampleInputEmail1">No Telepon</label>
                                <input type="number" class="form-control @error('telp') is-invalid @enderror"
                                    name="telp" value="{{ $anggota->no_telp_anggota }}">
                                @error('telp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="exampleInputEmail1">Alamat Anggota</label>
                                <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                    value="">{{ $anggota->alamat_anggota }}</textarea>
                                @error('alamat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
            </form>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Kembali</a>
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
                    <p>Apakah Anda Yakin Akan Keluar Dari Form Edit Data Anggota</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-primary">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
@endsection