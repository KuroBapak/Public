@extends('template.master')

@section('content')
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Input Data Buku</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/buku/store" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Kode Buku</label>
                    <input type="number" class="form-control" name="kode_buku" placeholder="Input Kode Buku">
                    <label for="exampleInputEmail1">Judul Buku</label>
                    <input type="text" class="form-control" name="judul_buku" placeholder="Input Judul Buku">
                    <label for="exampleInputEmail1">Penulis Buku</label>
                    <input type="text" class="form-control" name="penulis_buku" placeholder="Input Penulis Buku">
                    <label for="exampleInputEmail1">Penerbit Buku</label>
                    <input type="text" class="form-control" name="penerbit_buku" placeholder="Input Penerbit Buku">
                    <label for="exampleInputEmail1">Tahun Penerbitan</label>
                    <input type="number" class="form-control" name="tahun_penerbit" placeholder="Input Tahun Penerbitan">
                    <label for="exampleInputEmail1">Stok Buku</label>
                    <input type="number" class="form-control" name="stok" placeholder="Input Sisa Stock">
                  </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="submit" value="Save" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
</div>
@endsection

