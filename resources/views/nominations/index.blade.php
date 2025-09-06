@extends('layouts.app')

@section('title', 'Nominations Management - Ngoma Awards')

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .dataTables_filter {
        margin-bottom: 15px;
    }
    .badge-pending { background-color: #6c757d; }
    .badge-approved { background-color: #198754; }
    .badge-rejected { background-color: #dc3545; }
    .table th { border-top: none; }
    .action-buttons .btn { padding: 0.25rem 0.5rem; }
    .select2-container--default .select2-selection--multiple { border: 1px solid #ced4da; }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Nominations Management</h5>
                    <div>
                        <a href="{{ route('nominations.export') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-download me-1"></i> Export
                        </a>
                        <a href="{{ route('nominations.cluster') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-bar-chart me-1"></i> View Analytics
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="categoryFilter" class="form-label">Category</label>
                            <select id="categoryFilter" class="form-select form-select-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select id="statusFilter" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="dateFromFilter" class="form-label">From Date</label>
                            <input type="date" id="dateFromFilter" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="dateToFilter" class="form-label">To Date</label>
                            <input type="date" id="dateToFilter" class="form-control form-control-sm">
                        </div>
                    </div>

                    <!-- DataTable -->
                    <div class="table-responsive">
                        <table id="nominationsTable" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Nominee</th>
                                    <th>Details</th>
                                    <th>Submitted By</th>
                                    <th>Status</th>
                                    <th>Submitted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Nomination Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" id="nominationId" name="nomination_id">
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Status</label>
                        <select class="form-select" id="statusSelect" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#categoryFilter').select2({
        placeholder: "Filter by category",
        allowClear: true
    });

    // Initialize DataTable
    const table = $('#nominationsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '{{ route('nominations.index') }}',
            data: function (d) {
                d.category = $('#categoryFilter').val();
                d.status = $('#statusFilter').val();
                d.date_from = $('#dateFromFilter').val();
                d.date_to = $('#dateToFilter').val();
            }
        },
        columns: [
            { data: 'id', name: 'id', width: '5%' },
            { data: 'category', name: 'category' },
            { 
                data: 'nominee_name', 
                name: 'nominee_name',
                render: function(data, type, row) {
                    return data || 'N/A';
                }
            },
            { 
                data: 'details', 
                name: 'details',
                render: function(data, type, row) {
                    return data || 'N/A';
                }
            },
            { 
                data: 'user.name', 
                name: 'user.name',
                render: function(data, type, row) {
                    return data || 'Anonymous';
                }
            },
            { 
                data: 'status', 
                name: 'status',
                render: function(data, type, row) {
                    const badgeClass = {
                        'pending': 'badge-pending',
                        'approved': 'badge-approved',
                        'rejected': 'badge-rejected'
                    }[data] || 'badge-secondary';
                    
                    return `<span class="badge ${badgeClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data, type, row) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="action-buttons">
                            <a href="{{ url('nominations') }}/${row.id}" class="btn btn-sm btn-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ url('nominations') }}/${row.id}/edit" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-primary update-status" data-id="${row.id}" data-status="${row.status}" title="Update Status">
                                <i class="bi bi-gear"></i>
                            </button>
                            <form action="{{ url('nominations') }}/${row.id}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-sm btn-secondary'
            },
            {
                extend: 'csv',
                className: 'btn btn-sm btn-success'
            },
            {
                extend: 'excel',
                className: 'btn btn-sm btn-success'
            },
            {
                extend: 'pdf',
                className: 'btn btn-sm btn-danger'
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-info'
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search nominations..."
        }
    });

    // Apply filters
    $('#categoryFilter, #statusFilter, #dateFromFilter, #dateToFilter').on('change', function() {
        table.ajax.reload();
    });

    // Status update modal
    $(document).on('click', '.update-status', function() {
        const nominationId = $(this).data('id');
        const currentStatus = $(this).data('status');
        
        $('#nominationId').val(nominationId);
        $('#statusSelect').val(currentStatus);
        $('#statusModal').modal('show');
    });

    // Status form submission
    $('#statusForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const url = '{{ route("nominations.updateStatus", ":id") }}'.replace(':id', $('#nominationId').val());
        
        $.ajax({
            url: url,
            type: 'PATCH',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#statusModal').modal('hide');
                table.ajax.reload();
                showToast('Status updated successfully!', 'success');
            },
            error: function(xhr) {
                showToast('Error updating status.', 'error');
            }
        });
    });

    function showToast(message, type = 'success') {
        // You can implement a toast notification here
        alert(message);
    }
});
</script>
@endpush