@extends('layouts.app')

@section('title', 'Student Management - Student List')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-list"></i> Students</h1>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('students.create') }}">
                <i class="fas fa-plus"></i> Add Student
            </a>
            <a class="btn btn-secondary" href="{{ route('students.export', request()->query()) }}">
                <i class="fas fa-download"></i> Export CSV
            </a>
            <form method="POST" action="{{ route('students.delete-all') }}" onsubmit="confirmDelete(event, this, 'Are you sure you want to delete ALL students? This action will apply to every record in the database.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete All
                </button>
            </form>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter"></i> Filters & Search
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}" class="row g-3">
                <div class="col-12 col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone..." class="form-control">
                </div>
                <div class="col-12 col-md-3">
                    <select name="status" class="form-select">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request()->hasAny(['search', 'status']) && request('status') !== 'all')
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions Controls -->
    <form id="bulk-form" method="POST" action="" style="display: none;">
        @csrf
    </form>
    <div class="card mb-4">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <label class="form-check-label">
                        <input type="checkbox" id="select-all" class="form-check-input"> Select All
                    </label>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <select id="bulk-action" class="form-select form-select-sm" style="width: auto;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected (Soft)</option>
                        <option value="force-delete">Permanent Delete</option>
                        <option value="status-active">Set Active</option>
                        <option value="status-inactive">Set Inactive</option>
                        <option value="status-graduated">Set Graduated</option>
                    </select>
                    <button type="button" id="apply-bulk" class="btn btn-primary btn-sm" disabled>
                        <i class="fas fa-check"></i> Apply Action
                    </button>
                    <div class="vr mx-2"></div>
                    <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm" disabled>
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                    <button type="button" id="bulk-force-delete-btn" class="btn btn-outline-danger btn-sm" disabled>
                        <i class="fas fa-exclamation-triangle"></i> Permanent Delete
                    </button>
                    <span class="text-muted ms-3" style="font-size: 0.9rem;">
                        Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="select-all-header" class="form-check-input">
                            </th>
                            <th>
                                <a href="{{ $students->url($students->currentPage()) . '&sort=name&direction=' . (request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc') }}" style="text-decoration: none; color: inherit;">
                                    Name
                                    @if(request('sort') == 'name')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort text-muted"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ $students->url($students->currentPage()) . '&sort=email&direction=' . (request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc') }}" style="text-decoration: none; color: inherit;">
                                    Email
                                    @if(request('sort') == 'email')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort text-muted"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Phone</th>
                            <th>Grade</th>
                            <th>
                                <a href="{{ $students->url($students->currentPage()) . '&sort=status&direction=' . (request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc') }}" style="text-decoration: none; color: inherit;">
                                    Status
                                    @if(request('sort') == 'status')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort text-muted"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Created</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="form-check-input student-checkbox">
                                </td>
                                <td>
                                    <strong>{{ $student->name }}</strong>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>{{ $student->grade ?? '-' }}</td>
                                <td>
                                    @php
                                        $statusClass = match($student->status) {
                                            'active' => 'badge-active',
                                            'inactive' => 'badge-inactive',
                                            'graduated' => 'badge-graduated',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        <i class="fas fa-{{ $student->status == 'active' ? 'check-circle' : ($student->status == 'inactive' ? 'times-circle' : 'graduation-cap') }}"></i>
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td>{{ $student->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-outline-primary" href="{{ route('students.show', $student) }}" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-outline-warning" href="{{ route('students.edit', $student) }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('students.destroy', $student) }}" style="display: inline;" onsubmit="confirmDelete(event, this, 'Delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox"></i> No students found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
        <nav aria-label="Page navigation">
            {{ $students->appends(request()->query())->links() }}
        </nav>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const selectAllHeader = document.getElementById('select-all-header');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const bulkActionSelect = document.getElementById('bulk-action');
    const applyBulkButton = document.getElementById('apply-bulk');
    const bulkForm = document.getElementById('bulk-form');

    function toggleSelectAll(checked) {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
        updateBulkButton();
    }

    selectAllCheckbox.addEventListener('change', function() {
        toggleSelectAll(this.checked);
        if (selectAllHeader) selectAllHeader.checked = this.checked;
    });

    if (selectAllHeader) {
        selectAllHeader.addEventListener('change', function() {
            toggleSelectAll(this.checked);
            selectAllCheckbox.checked = this.checked;
        });
    }

    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === studentCheckboxes.length;
            if (selectAllHeader) selectAllHeader.checked = selectAllCheckbox.checked;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < studentCheckboxes.length;
            updateBulkButton();
        });
    });

    bulkActionSelect.addEventListener('change', updateBulkButton);

    applyBulkButton.addEventListener('click', function() {
        const action = bulkActionSelect.value;
        if (!action) return;

        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select at least one student.');
            return;
        }

        if (action === 'delete') {
            confirmAction(`Delete ${checkedBoxes.length} selected student(s)?`, () => {
                bulkForm.action = '{{ route("students.bulk.delete") }}';
                bulkForm.method = 'POST';
                let methodInput = bulkForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    bulkForm.appendChild(methodInput);
                }
                methodInput.value = 'DELETE';
                submitBulkForm(checkedBoxes);
            });
            return;
        } else if (action === 'force-delete') {
            confirmAction(`PERMANENTLY DELETE ${checkedBoxes.length} selected student(s)? This cannot be undone!`, () => {
                bulkForm.action = '{{ route("students.bulk.force-delete") }}';
                bulkForm.method = 'POST';
                let methodInput = bulkForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    bulkForm.appendChild(methodInput);
                }
                methodInput.value = 'DELETE';
                submitBulkForm(checkedBoxes);
            });
            return;
        } else if (action.startsWith('status-')) {
            const status = action.replace('status-', '');
            bulkForm.action = '{{ route("students.bulk.status") }}';
            bulkForm.method = 'POST';

            let methodInput = bulkForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                bulkForm.appendChild(methodInput);
            }
            methodInput.value = 'PATCH';

            let statusInput = bulkForm.querySelector('input[name="status"]');
            if (!statusInput) {
                statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                bulkForm.appendChild(statusInput);
            }
            statusInput.value = status;
            submitBulkForm(checkedBoxes);
        }

        function submitBulkForm(boxes) {
            const existingInputs = bulkForm.querySelectorAll('input[name="student_ids[]"]');
            existingInputs.forEach(input => input.remove());
            boxes.forEach(cb => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'student_ids[]';
                hiddenInput.value = cb.value;
                bulkForm.appendChild(hiddenInput);
            });
            bulkForm.submit();
        }
    });

    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkForceDeleteBtn = document.getElementById('bulk-force-delete-btn');

    bulkDeleteBtn.addEventListener('click', function() {
        bulkActionSelect.value = 'delete';
        applyBulkButton.click();
    });

    bulkForceDeleteBtn.addEventListener('click', function() {
        bulkActionSelect.value = 'force-delete';
        applyBulkButton.click();
    });

    function updateBulkButton() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        const hasSelection = checkedBoxes.length > 0;
        const hasAction = bulkActionSelect.value !== '';

        applyBulkButton.disabled = !hasSelection || !hasAction;
        bulkDeleteBtn.disabled = !hasSelection;
        bulkForceDeleteBtn.disabled = !hasSelection;

        if (hasSelection && hasAction) {
            applyBulkButton.textContent = `✓ Apply to ${checkedBoxes.length} student(s)`;
        } else {
            applyBulkButton.textContent = '✓ Apply';
        }
    }
});
</script>
@endsection
