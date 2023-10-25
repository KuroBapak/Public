@extends('template.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Film</h1>
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
          <form action="{{ route('peran.store', $datafilm[0]->id)}}" method="POST">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="judul">Judul Film</label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukan Judul Film" disabled value="{{ $datafilm[0]->judul }}">
              </div>
              @error('judul')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="hidden" value="{{ $datafilm[0]->id}}" name="film_id">
              <div class="form-group">
                  <label for="cast">cast</label>
                  {{-- <input type="text" name="cast" id="cast"  class="form-control" placeholder="Enter cast Anda"> --}}
                  <select name="cast_id" id="cast" class="form-control @error('cast_id') is-invalid @enderror">
                        <option disabled selected>--Pilih Salah Satu--</option>
                   @forelse ($casts as $value )
                        <option value="{{ $value->id}}">{{ $value->nama}}</option>
                   @empty
                        <option disabled>--Data Masih Kosong--</option>
                   @endforelse
                </select>
                </div>
                @error('cast')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              <div class="form-group">
                <label for="peran">peran</label>
                <input type="text" name="peran" id="peran" class="form-control @error('peran') is-invalid @enderror" placeholder="Masukan peran from cast">
              </div>
              @error('peran')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="card-footer">
              <a href="{{ route('film.index')}}" class="btn btn-info">Back</a>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
</div>  
<!-- /.content -->
@endsection