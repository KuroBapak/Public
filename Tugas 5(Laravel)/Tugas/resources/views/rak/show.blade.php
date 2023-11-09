@extends('template.master')

@section('content')
    <div class="content-wrapper">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Form Detail Data Rak</h3>
            </div>

            <form action="{{ route('rak.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Rak</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="NamaRak1">Nama Rak</label>
                                    <input type="text" class="form-control"
                                       value="{{ $rak->nama_rak }}" name="nama" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="Lokasi1">Lokasi</label>
                                    <input type="text" class="form-control"
                                     value="{{ $rak->lokasi_rak }}" name="lokasi" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="JudulBuku">Alamat</label>
                                    <input type="text" class="form-control" name="buku"
                                        value="{{ $rak->buku->judul_buku }}" disabled>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <a href="" class="btn btn-info" data-toggle="modal"
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
                                <p>Apakah Anda Yakin Akan Keluar Dari Form Detail Data Rak</p>
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