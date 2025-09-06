@extends('layouts.app')

@section('title', 'Ngoma Awards — Dashboard')

@section('hero')
<section class="position-relative text-center text-white" style="height: 80vh; background: url('{{ asset('image/hero.jpg') }}') center/cover no-repeat;">
  <!-- Overlay -->
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.6);"></div>

  <!-- Content -->
  <div class="d-flex flex-column justify-content-center align-items-center h-100 position-relative">
      <img src="{{ asset('image/ngoma.png') }}" 
           alt="Ngoma Awards Logo" 
           class="img-fluid" 
           style="height: 90px;px; max-height:150px;"><br>
<a href="/categories" 
   class="btn btn-lg fw-semibold px-5 py-3 rounded-pill shadow border-0"
   style="background: linear-gradient(90deg, #b8860b, #ffd700, #daa520); 
          color:#000; 
          font-size:18px; 
          text-shadow:0 1px 1px rgba(255,255,255,0.6);">
  Nominate Now
</a>

  </div>
</section>


@endsection
