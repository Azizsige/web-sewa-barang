<!-- resources/views/layouts/navbar.blade.php -->
<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
          <i class="ti ti-bell-ringing"></i>
          <div class="notification bg-primary rounded-circle"></div>
        </a>
      </li>
      @if(auth()->check())
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
      </li>
      @endif
    </ul>
    <div class="px-0 navbar-collapse justify-content-end" id="navbarNav">
      <ul class="flex-row navbar-nav ms-auto align-items-center justify-content-end">
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
              <div class="gap-2 d-flex align-items-center dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">{{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
              </div>
              <a href="{{ route('profile.edit') }}" class="gap-2 d-flex align-items-center dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">My Profile</p>
              </a>
              <a href="javascript:void(0)" class="gap-2 d-flex align-items-center dropdown-item">
                <i class="ti ti-mail fs-6"></i>
                <p class="mb-0 fs-3">My Account</p>
              </a>
              <a href="javascript:void(0)" class="gap-2 d-flex align-items-center dropdown-item">
                <i class="ti ti-list-check fs-6"></i>
                <p class="mb-0 fs-3">My Task</p>
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mx-3 mt-2 btn btn-outline-primary d-block">Logout</button>
              </form>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>