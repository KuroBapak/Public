  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">

  <div class="card card-warning">
      <div class="card-header">
          <h3 class="card-title">Form Edit Data Buku</h3>
      </div>
      <form action="{{ route('buku.update', $bukus->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">
              <div class="card card-warning">
                  <div class="card-header">
                      <h3 class="card-title">Quick Example</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form>
                      <div class="card-body">
                          <div class="form-group">
                              <label for="exampleInputKodeBuku1">Kode Buku</label>
                              <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                  name="kode"" name="kode" id="exampleInputKodeBuku1"
                                  value="{{ $bukus->kode_buku }}">
                          </div>
                          @error('kode')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label for="exampleInputJudulBuku1">Judul Buku</label>
                              <input type="text" class="form-control  @error('judul') is-invalid @enderror" name="judul" id="exampleInputJudulBuku1"
                                  value="{{ $bukus->judul_buku }}">
                          </div>
                          @error('judul')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label for="exampleInputPenulisBuku1">Penulis Buku</label>
                              <input type="text" class="form-control  @error('penulis') is-invalid @enderror" name="penulis" id="exampleInputPenulisBuku1"
                                  value="{{ $bukus->penulis_buku }}">
                          </div>
                          @error('penulis')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label for="exampleInputPenerbitBuku1">Penerbit Buku</label>
                              <input type="text" class="form-control  @error('penerbit') is-invalid @enderror" name="penerbit" id="exampleInputPenerbitBuku1"
                                  value="{{ $bukus->penerbit_buku }}">
                          </div>
                          @error('penerbit')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label for="tahun">Tahun Penerbit</label>
                              <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" min="2000"
                                  max="2099" step="1" value="{{ $bukus->tahun_penerbit }}">
                          </div>
                          @error('tahun')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                          <label for="exampleInputStok1">Stok</label>
                          <input type="number" class="form-control  @error('stok') is-invalid @enderror" name="stok" id="exampleInputStok1"
                              value="{{ $bukus->stok }}">
                              @error('stok')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                      <!-- /.card-body -->
            </form>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Kembali</a>
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
                          <p>Apakah Anda Yakin Akan Keluar Dari Form Edit Data Buku</p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                          <a href="{{ route('buku.index') }}" class="btn btn-warning">Yes</a>
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