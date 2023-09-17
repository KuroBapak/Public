@extends('template.master')

@section('content')
<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form Input Data Anggota</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('anggota.store')}}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Anggota</label>
                  <input type="text" class="form-control" name="kode_anggota" placeholder="Input Kode Anggota">
                  <label for="exampleInputEmail1">Nama Anggota</label>
                  <input type="text" class="form-control" name="nama_anggota" placeholder="Input Nama Anggota">
                      <label>Jenis Kelamin</label>
                      <select type="text" name="jk_anggota" class="form-control">
                        <option disabled>Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                  <label for="exampleInputEmail1">Jurusan anggota</label>
                  <input type="text" class="form-control" name="jurusan_anggota" placeholder="Input Jurusan Anggota">
                  <label for="exampleInputEmail1">No Telepon</label>
                  <input type="number" class="form-control" name="no_telp_anggota" placeholder="Input No Telp Anggota">
                  <label for="exampleInputEmail1">Alamat Anggota</label>
                  <input type="text" class="form-control" name="alamat_anggota" placeholder="Input Alamat Anggota">
                </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
              </div>
            </form>
          </div>
</div>
@endsection