<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start ms-4" id="sidenav-main" style="height: auto; min-height: calc(100vh - 2rem); margin-top: 1rem;">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/dashboard') }}">
      <img src="{{ asset('dashboard-admin/assets/img/logo-ct-dark.png') }}" width="26" height="26" class="navbar-brand-img h-100" alt="logo">
      <span class="ms-1 font-weight-bold">Arimbi Busana</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto h-auto pb-4" id="sidenav-collapse-main" style="overflow: visible !important;">
    <ul class="navbar-nav">
      <!-- Navigasi Publik -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-globe text-info text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Lihat Beranda</span>
        </a>
      </li>
      
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Admin</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-house text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('dashboard/products*') ? 'active' : '' }}" href="{{ route('dashboard.products.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-boxes-packing text-warning text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Daftar Produk</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('dashboard/orders*') ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-bag-shopping text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Daftar Pesanan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/categories*') ? 'active' : '' }}" href="{{ route('dashboard.categories.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-layer-group text-success text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Kategori</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/testimonials*') ? 'active' : '' }}" href="{{ route('dashboard.testimonials.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-comment-dots text-info text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Testimonial</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/announcements*') ? 'active' : '' }}" href="{{ route('dashboard.announcements.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-circle-info text-danger text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Popup Info</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/blogs*') ? 'active' : '' }}" href="{{ route('dashboard.blogs.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-newspaper text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Kelola Blog</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/settings*') ? 'active' : '' }}" href="{{ route('dashboard.settings.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-sliders text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Pengaturan</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Opsi</h6>
      </li>

      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar" class="d-none">
          @csrf
        </form>
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-right-from-bracket text-danger text-sm"></i>
          </div>
          <span class="nav-link-text ms-1 text-danger font-weight-bold">Keluar</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
