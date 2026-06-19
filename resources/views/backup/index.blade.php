@extends('layouts.app')

@section('title', 'Database Backups - Student Management')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-database"></i> Database Backups</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBackupModal">
                <i class="fas fa-plus"></i> Create Backup
            </button>
        </div>
    </div>

    <!-- Backup List -->
    <div class="card">
        <div class="card-body">
            @if($backups->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Filename</th>
                                <th>Size</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $backup['filename'] }}</div>
                                    <small class="text-muted">{{ $backup['path'] }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ number_format($backup['size'] / 1024, 1) }} KB</span>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::createFromTimestamp($backup['created_at'])->format('M j, Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::createFromTimestamp($backup['created_at'])->format('g:i A') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('backup.download', $backup['filename']) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete('{{ $backup['filename'] }}')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-database fa-4x mb-3"></i>
                    <h4>No backups found</h4>
                    <p>Create your first database backup to get started.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBackupModal">
                        <i class="fas fa-plus"></i> Create First Backup
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Backup Modal -->
<div class="modal fade" id="createBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Database Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backup.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="backup_type" class="form-label">Backup Type</label>
                        <select name="table" id="backup_type" class="form-select">
                            <option value="">Full Database Backup</option>
                            <option value="students">Students Table Only</option>
                            <option value="users">Users Table Only</option>
                            <option value="audit_logs">Audit Logs Table Only</option>
                            
                        </select>
                        <div class="form-text">
                            Choose "Full Database Backup" to backup all tables, or select a specific table.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Backup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this backup file?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Backup
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(filename) {
    document.getElementById('deleteForm').action = '{{ url("/backup") }}/' + filename;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    margin-right: 2px;
}
</style>
@endsection