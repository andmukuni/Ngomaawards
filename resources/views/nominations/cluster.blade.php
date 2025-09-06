@extends('layouts.app')
@section('title','Similar Names Cluster')

@section('content')
<div class="container py-4">
  <h1 class="h5 mb-3">Similar names (SOUNDEX: <code>{{ $sx }}</code>)</h1>
  <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">← Back</a>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Category</th>
            <th>Nominee Name</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $i => $row)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row->category }}</td>
            <td>{{ $row->nominee_name }}</td>
            <td>{{ optional($row->created_at)->format('Y-m-d') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
