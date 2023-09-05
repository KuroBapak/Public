@extends('template.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blank Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">

        <table border="1" width="100%" style="text-align: center">
    <tr>
        <th>kode buku</th>
        <th>judul buku</th>
        <th>penulis buku</th>
        <th>penerbit buku</th>
        <th>tahun penerbit</th>
        <th>stok</th>
    </tr>
    @foreach($buku as $key)
    <tr>
        <td>{{$key->kode_buku}}</td>
        <td>{{$key->judul_buku}}</td>
        <td>{{$key->penulis_buku}}</td>
        <td>{{$key->penerbit_buku}}</td>
        <td>{{$key->tahun_penerbit}}</td>
        <td>{{$key->stok}}</td>
    </tr>
    @endforeach
</table><br>

<table border="1" width="100%" style="text-align: center">
    <tr>
        <th>kode anggota</th>
        <th>nama anggota</th>
        <th>jenis kelamin</th>
        <th>jurusan anggota</th>
        <th>no telepon</th>
        <th>alamat</th>
    </tr>
    @foreach($anggota as $w)
    <tr>
        <td>{{$w->kode_anggota}}</td>
        <td>{{$w->nama_anggota}}</td>
        <td>{{$w->jk_anggota}}</td>
        <td>{{$w->jurusan_anggota}}</td>
        <td>{{$w->no_telp_anggota}}</td>
        <td>{{$w->alamat_anggota}}</td>
    </tr>
    @endforeach
</table><br>

<table border="1" width="100%" style="text-align: center">
    <tr>
        <th>nama petugas</th>
        <th>jabatan petugas</th>
        <th>no telepon</th>
        <th>alamat petugas</th>
    </tr>
    @foreach($petugas as $key)
    <tr>
        <td>{{$key->nama_petugas}}</td>
        <td>{{$key->jabatan_petugas}}</td>
        <td>{{$key->no_telp_petugas}}</td>
        <td>{{$key->alamat_petugas}}</td>
    </tr>
    @endforeach
</table>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection