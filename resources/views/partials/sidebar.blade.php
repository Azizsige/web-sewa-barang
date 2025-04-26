<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
            aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        @if(auth()->check())
        @if(auth()->user()->role === 'admin')
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Manajemen Toko</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ Route::is('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"
            aria-expanded="false">
            <span>
              <i class="ti ti-box"></i>
            </span>
            <span class="hide-menu">Produk</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ Route::is('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"
            aria-expanded="false">
            <span>
              <i class="ti ti-tags"></i>
            </span>
            <span class="hide-menu">Kategori Produk</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ Route::is('rentals.*') ? 'active' : '' }}" href="{{ route('rentals.index') }}"
            aria-expanded="false">
            <span>
              <i class="ti ti-history"></i>
            </span>
            <span class="hide-menu">Riwayat Sewa</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Pengaturan</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-settings"></i>
            </span>
            <span class="hide-menu">Pengaturan Toko</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-brand-whatsapp"></i>
            </span>
            <span class="hide-menu">Tanya via WA</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-lock"></i>
            </span>
            <span class="hide-menu">Ganti Password</span>
          </a>
        </li>
        @endif

        @if(auth()->user()->role === 'developer')
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Manajemen Toko</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-store"></i>
            </span>
            <span class="hide-menu">Daftar Toko</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Manajemen User</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Manajemen User</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Moderasi</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ Route::is('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"
            aria-expanded="false">
            <span>
              <i class="ti ti-box"></i>
            </span>
            <span class="hide-menu">Lihat Produk Semua Toko</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Monitoring</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-activity"></i>
            </span>
            <span class="hide-menu">Monitoring Aktivitas</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Pengaturan</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <i class="ti ti-lock"></i>
            </span>
            <span class="hide-menu">Reset Password User</span>
          </a>
        </li>
        @endif
        @endif
      </ul>
    </nav>
  </div>
</aside>