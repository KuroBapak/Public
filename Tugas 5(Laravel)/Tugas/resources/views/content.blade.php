@extends('template.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang, {{Auth::user()->name}}</h1>
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
          <h3 class="card-title">Daftar Buku Dan Petugas jaga</h3>

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

          <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                  <th>kode buku</th>
                  <th>judul buku</th>
                  <th>penulis buku</th>
                  <th>penerbit buku</th>
                  <th>tahun penerbit</th>
                  <th>stok</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
            <tfoot>
            </tfoot>
        </table><br>

        <table id="example2" class="table table-bordered table-hover">
          <thead>
              <tr>
                <th>nama petugas</th>
                <th>jabatan petugas</th>
                <th>alamat petugas</th>
              </tr>
          </thead>
          <tbody>
            @foreach($petugas as $key)
            <tr>
                <td>{{$key->nama_petugas}}</td>
                <td>{{$key->jabatan_petugas}}</td>
                <td>{{$key->alamat_petugas}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
          </tfoot>
      </table><br>



        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
  </div>
    <!-- /.content -->
@endsection