@extends('layouts.app')

@section('title', 'Ngoma Awards')

@section('hero')
<section class="position-relative text-center text-white" style="height: 80vh; background: url('{{ asset('image/bunner.jpeg') }}') center/cover no-repeat;">
  <!-- Overlay -->
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.6);"></div>

  <!-- Center Content -->
  <div class="d-flex flex-column justify-content-center align-items-center h-100 position-relative" style="z-index:2;">

    <a href="/categories" 
       class="btn btn-lg fw-semibold px-5 py-3 rounded-pill shadow border-0"
       style="background: linear-gradient(90deg, #b8860b, #ffd700, #daa520); 
              color:#000; 
              font-size:50px; 
              text-shadow:0 1px 1px rgba(255,255,255,0.6);">
      Nominate Now
    </a>

    <!-- Small logo below the button -->
    <a href="{{ url('/') }}" class="d-inline-block mt-3" aria-label="Ngoma Awards Home">
      <img src="{{ asset('image/bunner2.png') }}"
           alt="Ngoma Awards Logo"
           class="img-fluid"
           loading="lazy"
           style="height:65px; width:auto; opacity:.95;">
    </a><br><br><br>
          <span class="d-inline-block px-2 fw-bold" style="letter-spacing:.03em; text-shadow:0 1px 1px rgba(0,0,0,.6);">
        <time datetime="2025-12-11">Thursday, 11th December 2025</time>.<br>
        <span style="text-transform:uppercase;">CIELA RESORT AND SPA Bonanza Estate, Lusaka.</span>
      </span>
  </div>


</section>
@endsection
