@extends('layouts.app')
@section('title','Nomination Data')

@section('content')
<div class="container py-4">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 m-0">Nomination Data</h1>
    <a id="exportLink"
       href="{{ route('nominations.export', request()->only(['q','category','year','status','domain'])) }}"
       class="btn btn-warning fw-semibold">
      <span class="bi bi-file-earmark-excel"></span> Get Excel Sheet
    </a>
  </div>

  {{-- Filters --}}
  <form method="GET" action="{{ route('nominationdata.index') }}" class="row g-2 align-items-end mb-3">
    <div class="col-md-3">
      <label class="form-label small">Search</label>
      <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search any field…">
    </div>
    <div class="col-md-2">
      <label class="form-label small">Category</label>
      <select name="category" class="form-select">
        <option value="">Any</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label small">Year</label>
      <select name="year" class="form-select">
        <option value="">Any</option>
        @foreach($years as $yr)
          <option value="{{ $yr }}" @selected(request('year')==$yr)>{{ $yr }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label small">Domain</label>
      <select name="domain" class="form-select">
        <option value="">Any</option>
        @foreach($domains as $dm)
          <option value="{{ $dm }}" @selected(request('domain')===$dm)>{{ $dm }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-1">
      <label class="form-label small">Status</label>
      <select name="status" class="form-select">
        <option value="">Any</option>
        @foreach(['pending','approved','rejected'] as $st)
          <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-1">
      <label class="form-label small">Per page</label>
      <select name="per_page" class="form-select">
        @foreach([10,25,50,100] as $n)
          <option value="{{ $n }}" @selected(request('per_page',25)==$n)>{{ $n }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-1 d-flex gap-2">
      <button class="btn btn-primary w-100 btn-submit">
        <span class="spinner-border spinner-border-sm me-1 d-none"></span> Apply
      </button>
    </div>
    <div class="col-md-1">
      <a href="{{ route('nominationdata.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
    </div>
  </form>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive" style="max-height:70vh; overflow:auto; position:relative;">
        <table class="table table-striped table-hover table-bordered align-middle w-100 border border-2 border-dark" id="dt-nominations">
          <thead>
          <tr class="align-middle">
            <th>Category</th>
            <th>Series Name</th>
            <th>Network</th>
            <th>Year</th>
            <th>Actress Name</th>
            <th>Actor Name</th>
            <th>Movie</th>
            <th>Role</th>
            <th>Song Title</th>
            <th>Artist</th>
            <th>Release Year</th>
            <th>Main Artist</th>
            <th>Featured Artists</th>
            <th>Stage Name</th>
            <th>Platform</th>
            <th>Profile URL</th>
            <th>Model Name</th>
            <th>Agency</th>
            <th>Portfolio URL</th>
            <th>Region</th>
            <th>Popular Song</th>
            <th>Domain</th>
            <th>Signature Work</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          @foreach($nominations as $n)
            <tr>
              <td>{{ data_get($n,'category') }}</td>
              <td>{{ data_get($n,'series_name') }}</td>
              <td>{{ data_get($n,'network') }}</td>
              <td>{{ data_get($n,'year') }}</td>
              <td>{{ data_get($n,'actress_name') }}</td>
              <td>{{ data_get($n,'actor_name') }}</td>
              <td>{{ data_get($n,'movie') }}</td>
              <td>{{ data_get($n,'role') }}</td>
              <td>{{ data_get($n,'song_title') }}</td>
              <td>{{ data_get($n,'artist') }}</td>
              <td>{{ data_get($n,'release_year') }}</td>
              <td>{{ data_get($n,'main_artist') }}</td>
              <td>{{ data_get($n,'featured_artists') }}</td>
              <td>{{ data_get($n,'stage_name') }}</td>
              <td>{{ data_get($n,'platform') }}</td>
              <td>
                @php $purl = data_get($n,'profile_url'); @endphp
                @if($purl)<a href="{{ $purl }}" target="_blank" rel="noopener">{{ $purl }}</a>@endif
              </td>
              <td>{{ data_get($n,'model_name') }}</td>
              <td>{{ data_get($n,'agency') }}</td>
              <td>
                @php $port = data_get($n,'portfolio_url'); @endphp
                @if($port)<a href="{{ $port }}" target="_blank" rel="noopener">{{ $port }}</a>@endif
              </td>
              <td>{{ data_get($n,'region') }}</td>
              <td>{{ data_get($n,'popular_song') }}</td>
              <td>{{ data_get($n,'domain') }}</td>
              <td>{{ data_get($n,'signature_work') }}</td>
              <td>{{ data_get($n,'status') }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>

        {{-- Laravel pagination --}}
        <div class="d-flex justify-content-end">
          {{ $nominations->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Styling: sticky bold header + no-wrap --}}
<style>
  #dt-nominations thead th{
    position: sticky; top: 0; z-index: 5;
    background:#0f172a; color:#fff; font-weight:800; letter-spacing:.02em;
    white-space:nowrap !important;
  }
  #dt-nominations.table-bordered > :not(caption) > * > * { border-color:#1f2937; }
  #dt-nominations td, #dt-nominations th, #dt-nominations td a {
    white-space:nowrap !important; overflow-wrap:normal !important; word-break:keep-all !important;
  }
</style>

<script>
  // Disable Apply button and show spinner on submit
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="{{ route('nominationdata.index') }}"]');
    if (!form) return;
    form.addEventListener('submit', function(){
      const btn = form.querySelector('.btn-submit') || form.querySelector('button[type="submit"]');
      if (!btn) return;
      btn.disabled = true;
      const sp = btn.querySelector('.spinner-border');
      if (sp) sp.classList.remove('d-none');
    });
  });
</script>
@endsection
