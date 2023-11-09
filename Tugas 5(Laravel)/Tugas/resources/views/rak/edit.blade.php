@extends('template.master')

@section('content')
    <div class="content-wrapper">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Edit Data Rak</h3>
            </div>

            <form action="{{ route('rak.update', $rak->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Rak</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNamaRak1">Nama Rak</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" value="{{ $rak->nama_rak }}">
                                </div>
                                @error('nama')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputLokasi1">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        name="lokasi" value="{{ $rak->lokasi_rak }}">
                                </div>
                                @error('lokasi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="buku">Buku</label>
                                    <select name="buku" id="buku"
                                        class="form-control @error('buku') is-invalid @enderror">
                                        <option disabled selected>--Pilih Salah Satu--</option>
                                        @forelse ($buku as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $value->id == $rak->id_buku ? 'selected' : '' }}>
                                                {{ $value->judul_buku }}
                                            </option>
                                        @empty
                                            <option disabled>--Data Masih Kosong--</option>
                                        @endforelse
                                    </select>
                                </div>
                                @error('buku')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                    <a href="" class="btn btn-warning" data-toggle="modal"
                                        data-target="#exampleModal">Kembali</a>
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
                                <p>Apakah Anda Yakin Akan Keluar Dari Form Edit Data Rak</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <a href="{{ route('rak.index') }}" class="btn btn-primary">Yes</a>
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