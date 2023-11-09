  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">

  <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title">Form Input Data Buku</h3>
      </div>
      <form action="{{ route('buku.store') }}" method="POST">
          @csrf
          <div class="card-body">
              <div class="card card-primary">
                  <div class="card-header">
                      <h3 class="card-title">Quick Example</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form>
                      <div class="card-body">
                          <div class="form-group">
                              <label for="exampleInputKodeBuku1">Kode Buku</label>
                              <input type="text" class="form-control" name="kode" id="exampleInputKodeBuku1"
                                  value="{{ $bukus->kode_buku }}" disabled>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputJudulBuku1">Judul Buku</label>
                              <input type="text" class="form-control" name="judul" id="exampleInputJudulBuku1"
                                  value="{{ $bukus->judul_buku }}" disabled>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPenulisBuku1">Penulis Buku</label>
                              <input type="text" class="form-control" name="penulis" id="exampleInputPenulisBuku1"
                                  value="{{ $bukus->penulis_buku }}" disabled>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPenerbitBuku1">Penerbit Buku</label>
                              <input type="text" class="form-control" name="penerbit" id="exampleInputPenerbitBuku1"
                                  value="{{ $bukus->penerbit_buku }}" disabled>
                          </div>
                          <div class="form-group">
                              <label for="tahun">Tahun Penerbit</label>
                              <input type="number" name="tahun" id="tahun" class="form-control" min="2000"
                                  max="2099" step="1" value="{{ $bukus->tahun_penerbit }}" disabled>
                          </div>
                          <label for="exampleInputStok1">Stok</label>
                          <input type="number" class="form-control" name="stok" id="exampleInputStok1"
                              value="{{ $bukus->stok }}" disabled>
                      </div>
                      <!-- /.card-body -->

                      <div class="card-footer">
                          <a href="" class="btn btn-info" data-toggle="modal"
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
                          <p>Apakah Anda Yakin Akan Keluar Dari Form Detail Data Buku</p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                          <a href="{{ route('buku.index') }}" class="btn btn-primary">Yes</a>
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