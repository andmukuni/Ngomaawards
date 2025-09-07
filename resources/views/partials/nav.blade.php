@php
  function nav_active($patterns) {
      $patterns = (array)$patterns;
      foreach ($patterns as $p) {
          if (request()->routeIs($p)) return 'active';
      }
      return '';
  }
@endphp

<nav class="navbar navbar-expand-lg sticky-top border-bottom border-dark nav-glass"
     style="position:sticky; top:0; background:url('{{ asset('image/nav-bg.png') }}') center/cover no-repeat; min-height:120px;">
  <div class="container d-flex align-items-center justify-content-between" style="gap:20px;">

    <!-- Logo (left) -->
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('image/logo.png') }}" alt="Ngoma Awards Logo"
           class="img-fluid" style="height:75px; max-height:90px;">
    </a>

    <!-- Toggler (mobile) -->
    <button class="navbar-toggler text-white" type="button"
            data-bs-toggle="collapse" data-bs-target="#navMain"
            aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list fs-1"></i>
    </button>

    <!-- Middle Menu -->
    <div id="navMain" class="collapse navbar-collapse justify-content-center">
      <ul class="navbar-nav mb-2 mb-lg-0 text-center" style="gap:20px;">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}" 
             href="{{ url('/') }}"
             style="{{ request()->routeIs('welcome') ? 'color:#FFD700; text-decoration:underline;' : 'color:#fff;' }}">
            Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}" 
             href="{{ url('/about') }}"
             style="{{ request()->routeIs('about*') ? 'color:#FFD700; text-decoration:underline;' : 'color:#fff;' }}">
            About
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('categories*') ? 'active' : '' }}" 
             href="{{ route('categories.index') }}"
             style="{{ request()->routeIs('categories*') ? 'color:#FFD700; text-decoration:underline;' : 'color:#fff;' }}">
            Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs(['events.show','events*']) ? 'active' : '' }}" 
             href="{{ url('/event') }}"
             style="{{ request()->routeIs(['events.show','events*']) ? 'color:#FFD700; text-decoration:underline;' : 'color:#fff;' }}">
            Event Detail
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" 
             href="{{ url('/contact') }}"
             style="{{ request()->routeIs('contact') ? 'color:#FFD700; text-decoration:underline;' : 'color:#fff;' }}">
            Contact
          </a>
        </li>
      </ul>
    </div>

    <!-- CTAs (right) -->
    <div class="d-none d-lg-flex" style="gap:10px;">
      <a href="{{ route('categories.index') }}"
         class="fw-semibold px-4 py-2 rounded-3"
         style="font-size:15px; background:linear-gradient(90deg,#b8860b,#ffd700,#daa520); color:#000; border:none;">
        Explore Categories <i class="bi bi-arrow-right-short ms-1"></i>
      </a>
      <a href="{{ route('categories.index') }}"
         class="fw-semibold px-4 py-2 rounded-3"
         style="font-size:15px; background:linear-gradient(90deg,#b8860b,#ffd700,#daa520); color:#000; border:none;">
        Get Ticket <i class="bi bi-arrow-right-short ms-1"></i>
      </a>
    </div>
  </div>
</nav>
