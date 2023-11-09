@extends('template.master')

@section('content')
    <div class="content-wrapper">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Input Data Pengembalian</h3>
            </div>

            <form action="{{ route('pengembalian.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pengembalian</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="TanggalPengembalian">Tanggal Pengembalian</label>
                                    <input type="date" class="form-control"
                                        name="pengembalian" value="{{ $pengembalian->tanggal_pengembalian }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="Denda">Denda</label>
                                    <input type="numeric" class="form-control"
                                        name="denda" value="{{ $pengembalian->denda }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="Buku">Buku</label>
                                    <input type="text" class="form-control"
                                        name="buku" value="{{ $bukus->judul_buku }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="Angoota">Angoota</label>
                                    <input type="text" class="form-control"
                                        name="angoota" value="{{ $anggotas->nama_anggota }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="Petugas">Petugasi</label>
                                    <input type="text" class="form-control"
                                        name="petugas" value="{{ $petugass->nama_petugas }}" disabled>
                                </div>


                                <div class="card-footer">
                                    <a href="" class="btn btn-secondary" data-toggle="modal"
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
                                <p>Apakah Anda Yakin Akan Keluar Dari Form Show Data Pengembalian</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <a href="{{ route('pengembalian.index') }}" class="btn btn-primary">Yes</a>
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