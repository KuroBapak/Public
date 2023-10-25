@extends('template.master')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start --> 
              <form action="{{ route('genre.update', $genres[0]->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama"  class="form-control @error('nama') is-invalid @enderror" value="{{$genre[0]->nama}}">
                  </div> 
                  @error('nama')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="{{ route('genre.index') }}" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Back</a>
                  </div>
              </form>
              <div class="modal" tabindex="-1" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Peringatan</h5>
                    </div>
                    <div class="modal-body">
                      <p>Apakah Anda Yakin Akan Keluar untuk Mengedit Data Genre</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                      <a href="{{ route('genre.index') }}" class="btn btn-primary">Yes</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection