<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/dashboard') }}">
      <img src="{{ asset('dashboard-admin/assets/img/logo-ct-dark.png') }}" width="26" height="26" class="navbar-brand-img h-100" alt="logo">
      <span class="ms-1 font-weight-bold">Arimbi Busana</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
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
        <a class="nav-link {{ Request::is('dashboard/settings*') ? 'active' : '' }}" href="{{ route('dashboard.settings.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-sliders text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Pengaturan</span>
        <a class="nav-link {{ Request::is('dashboard/blogs*') ? 'active' : '' }}" href="{{ route('dashboard.blogs.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-newspaper text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Kelola Blog</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer mx-3">
    <a class="btn btn-primary btn-sm mb-0 w-100" href="#" type="button">
      <i class="fa-solid fa-circle-question me-2"></i> Support
    </a>
  </div>
</aside>
