<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'XTRA Gym — Results Driven Fitness Trainings')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  {{-- Bootstrap 5 & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.min.css">


  {{-- App styles --}}
  <link href="{{ asset('styles.css?v=2') }}" rel="stylesheet">

  @stack('styles')
</head>
<body>


  {{-- Navbar --}}
  @include('partials.nav')

  {{-- Optional floating rail (toggle per page if you like) --}}
  <div class="action-rail">
    <a href="#" title="Login"><i class="bi bi-person"></i></a>
    <a href="#" title="Messages"><i class="bi bi-chat-dots"></i></a>
    <a href="#" title="Share"><i class="bi bi-share"></i></a>
    <a href="#" title="Bookmark"><i class="bi bi-bookmark"></i></a>
    <a href="#" title="Help"><i class="bi bi-question-circle"></i></a>
  </div>

  {{-- Optional chat bubble --}}
  <a href="#" class="chat-bubble" title="Chat with us">
    <i class="bi bi-chat-left-text"></i>
  </a>

  {{-- Page-level hero slot (so your home can inject the big hero) --}}
  @yield('hero')

  {{-- Flash / alerts --}}
  <div class="container mt-3">
    @if(session('status'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
  </div>

  {{-- Main content --}}
  <main>
    @yield('content')
  </main>

  {{-- Footer slot if needed --}}
  @yield('footer')

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- jQuery (required for DataTables) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>
  @stack('scripts')
</body>
</html>
