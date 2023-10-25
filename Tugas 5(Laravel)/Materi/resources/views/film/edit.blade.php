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
              <form action="{{ route('cast.update', $cast[0]->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama"  class="form-control @error('nama') is-invalid @enderror" value="{{$cast[0]->nama}}">
                  </div> 
                  @error('nama')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="umur">Umur</label>
                    <input type="number" name="umur" id="umur" class="form-control @error('umur') is-invalid @enderror" value="{{$cast[0]->umur}}">
                  </div>
                  @error('umur')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name="bio" id="bio" cols="30" rows="10" class="form-control @error('bio') is-invalid @enderror">{{$cast[0]->bio }}</textarea>
                  </div>
                  @error('bio')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                  </div>
              </form>
            </div>
            <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection