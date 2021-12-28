  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ url('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Aplikasi Kurir') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset(Auth::user()->foto) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Menu Utama
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('transaksi.admin') }}" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Semua Transaksi
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('transaksi.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Tabel Kurir
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Daftar Kurir
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('seller.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-user-tag"></i>
                  <p>
                    Seller
                  </p>
                </a>
              </li>
              <li class="nav-header">Konfigurasi</li>
              <li class="nav-item">
                <a href="{{ route('transaksi.br') }}" class="nav-link">
                  <i class="nav-icon fas fa-database"></i>
                  <p>
                    Backup & Restore
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('transaksi.appconfig') }}" class="nav-link">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                    Pengaturan
                  </p>
                </a>
              </li>
              <li class="nav-header">Dokumentasi</li>
              <li class="nav-item">
                <a href="{{ route('home.dokumentasi') }}" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Dokumentasi
                  </p>
                </a>
              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>