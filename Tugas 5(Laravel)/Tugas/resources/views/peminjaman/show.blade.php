@extends('template.master')

@section('content')
    <div class="content-wrapper">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Input Data Peminjaman</h3>
            </div>

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Peminjaman</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="TanggalPinjam">Tanggal Pinjam</label>
                                    <input type="date" class="form-control"
                                        name="pinjam" value="{{ $peminjaman->tanggal_pinjam }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="TanggalKembali">Tanggal Kembali</label>
                                    <input type="date" class="form-control"
                                        name="kembali" value="{{ $peminjaman->tanggal_kembali }}" disabled>
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
                                <p>Apakah Anda Yakin Akan Keluar Dari Form Show Data Peminjaman</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <a href="{{ route('peminjaman.index') }}" class="btn btn-primary">Yes</a>
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