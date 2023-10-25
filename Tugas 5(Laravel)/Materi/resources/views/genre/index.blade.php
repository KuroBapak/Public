@extends('template.master')

@push('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable Genre</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($genres as $key => $value)
                    <tr>
                        <td>{{ $key +1 }} </td>
                        <td>{{ $value->nama }} </td>
                        <td class="d-flex" style="gap:10px">
                            <a href="{{ route('genre.show', $value->id) }}" class="btn btn-small btn-info">Detail</a>
                            <a href="{{ route('genre.edit', $value->id) }}" class="btn btn-small btn-warning">Edit</a>
                            <form action="{{ route('genre.destroy', $value->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <a href="{{ route('genre.index') }}" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Hapus</a>
                              </form>
                        </td>
                    </tr>
                    <div class="modal" tabindex="-1" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Peringatan</h5>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda Yakin Akan Menghapus Data Genre</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                              <a href="{{ route('genre.index') }}" class="btn btn-primary">Yes</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </tbody>
                  <a href="{{ route('genre.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Genre
                  </a>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
</div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection
@push('script')
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $
  });
</script>
@endpush