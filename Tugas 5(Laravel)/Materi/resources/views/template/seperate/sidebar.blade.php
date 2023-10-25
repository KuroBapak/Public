<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="sidebar">
  <!-- Brand Logo -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('adminLte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a class="d-block">Alexander Pierce</a>
    </div>
  </div>

      <!-- Sidebar -->
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary btn-block">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
        </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ asset('film')}}" class="nav-link @if(Request::segment(1) == 'film') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Films</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ asset('genre')}}" class="nav-link @if(Request::segment(1) == 'genre') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Genre</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ asset('cast')}}" class="nav-link @if(Request::segment(1) == 'cast') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Cast</p>
              </a>
            </li>
          </ul>
        </li>
  <!-- /.sidebar -->
</aside>