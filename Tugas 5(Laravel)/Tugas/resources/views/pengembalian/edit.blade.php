@extends('template.master')

@section('content')
    <div class="content-wrapper">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Input Data Pengembalian</h3>
            </div>

            <form action="{{ route('pengembalian.update', $pengembalian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Pengembaliann</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="Tanggal Pengembalian">Tanggal pengembalian</label>
                                    <input type="date" class="form-control @error('pengembalian') is-invalid @enderror"
                                        name="pengembalian" value="{{ $pengembalian->tanggal_pengembalian }}">
                                </div>
                                @error('pengembalian')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="Denda">Denda</label>
                                    <input type="number" class="form-control @error('denda') is-invalid @enderror"
                                        name="denda" value="{{ $pengembalian->denda }}">
                                </div>
                                @error('denda')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="buku">Buku</label>
                                    <select name="buku" id="buku"
                                        class="form-control @error('buku') is-invalid @enderror">
                                        <option disabled selected>--Pilih Salah Satu--</option>
                                        @forelse ($bukus as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $value->id == $pengembalian->id_buku ? 'selected' : '' }}>
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
                                <div class="form-group">
                                    <label for="anggota">Anggota</label>
                                    <select name="anggota" id="anggota"
                                        class="form-control @error('anggota') is-invalid @enderror">
                                        <option disabled selected>--Pilih Salah Satu--</option>
                                        @forelse ($anggotas as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $value->id == $pengembalian->id_anggota ? 'selected' : '' }}>
                                                {{ $value->nama_anggota }}
                                            </option>
                                        @empty
                                            <option disabled>--Data Masih Kosong--</option>
                                        @endforelse
                                    </select>
                                </div>
                                @error('anggota')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="petugas">Petugas</label>
                                    <select name="petugas" id="petugas"
                                        class="form-control @error('petugas') is-invalid @enderror">
                                        <option disabled selected>--Pilih Salah Satu--</option>
                                        @forelse ($petugass as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $value->id == $pengembalian->id_petugas ? 'selected' : '' }}>
                                                {{ $value->nama_petugas }}
                                            </option>
                                        @empty
                                            <option disabled>--Data Masih Kosong--</option>
                                        @endforelse
                                    </select>
                                </div>
                                @error('petugas')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
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
                                <p>Apakah Anda Yakin Akan Keluar Dari Form Edit Data Pengembalian</p>
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