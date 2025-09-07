@extends('layouts.app')
@section('title','Nomination Data')

@section('content')
<div class="container py-4">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 m-0">Nomination Data</h1>
    <a id="exportLink" href="{{ route('nominations.export') }}" class="btn btn-warning fw-semibold">
      <i class="bi bi-file-earmark-excel"></i> Get Excel Sheet
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive" style="max-height:70vh; overflow:auto; position:relative;">
        <table id="dt-nominations" class="table table-striped table-hover table-bordered align-middle w-100 border border-2 border-dark">
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
            </tr>
          @endforeach
          </tbody>
        </table>
        {{ $nominations->withQueryString()->links() }}
      </div>
    </div>
  </div>

</div>

{{-- DataTables CDN --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<style>
  /* Sticky, bold header and visible borders */
  #dt-nominations thead th{
    position: sticky; top: 0; z-index: 5;
    background: #0f172a; color: #fff;
    font-weight: 800; letter-spacing: .02em;
    white-space: nowrap !important;
  }
  #dt-nominations.table-bordered > :not(caption) > * > * {
    border-color: #1f2937;
  }
  /* NO WRAP ANYWHERE (cells + links) */
  #dt-nominations td,
  #dt-nominations th,
  #dt-nominations td a {
    white-space: nowrap !important;
    overflow-wrap: normal !important;
    word-break: keep-all !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = $('#dt-nominations').DataTable({
      responsive: false,              // keep columns in a single row
      autoWidth: false,
      scrollX: true,                  // horizontal scroll for overflow
      paging: true,                   // ensure pagination is on
      pageLength: 25,                 // default rows per page
      lengthMenu: [10, 25, 50, 100],  // user can change page size
      info: true,                     // "Showing 1 to 25 of N entries"
      searching: true,
      ordering: true,
      order: [],                      // no default sort
      language: {
        searchPlaceholder: 'Search any field…',
        lengthMenu: 'Show _MENU_ rows'
      },
      columnDefs: [{ targets: '_all', className: 'text-nowrap' }]
    });

    // dynamic export link (include current search)
    const exportBase = "{{ route('nominations.export') }}";
    const $export = document.getElementById('exportLink');
    const syncExportHref = () => {
      const q = table.search().trim();
      $export.href = q ? `${exportBase}?q=${encodeURIComponent(q)}` : exportBase;
    };
    table.on('search.dt', syncExportHref);
    syncExportHref();
  });
</script>
@endsection
