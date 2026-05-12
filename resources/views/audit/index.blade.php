@extends('layouts.app')

@section('title', 'Audit Logs - Student Management')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-history"></i> Audit Logs</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="user" class="form-label">User</label>
                    <select name="user" id="user" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="action" class="form-label">Action</label>
                    <select name="action" id="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                        <option value="upload_document" {{ request('action') == 'upload_document' ? 'selected' : '' }}>Upload Document</option>
                        <option value="delete_document" {{ request('action') == 'delete_document' ? 'selected' : '' }}>Delete Document</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('audit.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card">
        <div class="card-body">
            @if($auditLogs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Details</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auditLogs as $log)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $log->created_at->format('M j, Y') }}</div>
                                    <small class="text-muted">{{ $log->created_at->format('g:i A') }}</small>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div>{{ $log->user->name }}</div>
                                        <small class="text-muted">{{ $log->user->email }}</small>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $actionClass = match($log->action) {
                                            'create' => 'badge-success',
                                            'update' => 'badge-warning',
                                            'delete' => 'badge-danger',
                                            'upload_document' => 'badge-info',
                                            'delete_document' => 'badge-secondary',
                                            default => 'badge-secondary'
                                        };
                                        $actionIcon = match($log->action) {
                                            'create' => 'plus',
                                            'update' => 'edit',
                                            'delete' => 'trash',
                                            'upload_document' => 'upload',
                                            'delete_document' => 'trash',
                                            default => 'cog'
                                        };
                                    @endphp
                                    <span class="badge {{ $actionClass }}">
                                        <i class="fas fa-{{ $actionIcon }}"></i>
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($log->model_type && $log->model_id)
                                        <div class="fw-bold">{{ class_basename($log->model_type) }}</div>
                                        <small class="text-muted">ID: {{ $log->model_id }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->new_values)
                                        <button class="btn btn-sm btn-outline-info" onclick="showDetails({{ $log->id }})">
                                            <i class="fas fa-eye"></i> View Details
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <code class="small">{{ $log->ip_address ?? '-' }}</code>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $auditLogs->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-history fa-4x mb-3"></i>
                    <h4>No audit logs found</h4>
                    <p>Activity logs will appear here as users interact with the system.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(logId) {
    // For demo purposes, show a simple message
    // In a real app, you'd fetch the details via AJAX
    const content = `
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Log ID:</strong> ${logId}<br>
            <strong>Note:</strong> Detailed change information would be displayed here in a production system.
        </div>
    `;
    document.getElementById('detailsContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('detailsModal')).show();
}
</script>

<style>
.badge-success { background-color: #28a745; color: white; }
.badge-warning { background-color: #ffc107; color: black; }
.badge-danger { background-color: #dc3545; color: white; }
.badge-info { background-color: #17a2b8; color: white; }
.badge-secondary { background-color: #6c757d; color: white; }

@media print {
    .btn, .page-header .d-flex, .card.mb-4 {
        display: none !important;
    }
    .container-lg {
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>
@endsection