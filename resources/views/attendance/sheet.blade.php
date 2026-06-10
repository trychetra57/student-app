@extends('layouts.app')

@section('title', 'Attendance Sheet - ' . $class->name)

@section('content')
<div class="container-lg">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-calendar-check text-primary"></i> Attendance Sheet</h1>
            <p class="text-muted mb-0">Class: <strong>{{ $class->name }}</strong> · Date: <strong>{{ $date->format('M d, Y') }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.sheet', $class) }}" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label class="form-label mb-0">Select Date:</label>
                </div>
                <div class="col-auto">
                    <input type="date" name="date" class="form-control" value="{{ $date->toDateString() }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Change Date</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Attendance Sheet Form --}}
    <form method="POST" action="{{ route('attendance.store', $class) }}">
        @csrf
        <input type="hidden" name="date" value="{{ $date->toDateString() }}">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list text-primary"></i> Student Roster</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="markAll('present')">
                        <i class="fas fa-check"></i> Mark All Present
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="markAll('absent')">
                        <i class="fas fa-times"></i> Mark All Absent
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                @if($class->students->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th class="text-center" style="width: 280px;">Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $student)
                            @php
                                $status = isset($existing[$student->id]) ? $existing[$student->id]->status : 'present';
                                $remark = isset($existing[$student->id]) ? $existing[$student->id]->remarks : '';
                            @endphp
                            <tr>
                                <td class="text-muted">#{{ $student->id }}</td>
                                <td class="fw-bold">{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td class="text-center">
                                    <div class="btn-group w-100" role="group" aria-label="Attendance Status">
                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" value="present" id="present_{{ $student->id }}" {{ $status === 'present' ? 'checked' : '' }}>
                                        <label class="btn btn-sm btn-outline-success w-100 py-2" for="present_{{ $student->id }}"><i class="fas fa-check me-1"></i>Present</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" value="late" id="late_{{ $student->id }}" {{ $status === 'late' ? 'checked' : '' }}>
                                        <label class="btn btn-sm btn-outline-warning w-100 py-2" for="late_{{ $student->id }}"><i class="fas fa-clock me-1"></i>Late</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" value="absent" id="absent_{{ $student->id }}" {{ $status === 'absent' ? 'checked' : '' }}>
                                        <label class="btn btn-sm btn-outline-danger w-100 py-2" for="absent_{{ $student->id }}"><i class="fas fa-times me-1"></i>Absent</label>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="remarks[{{ $student->id }}]" class="form-control form-control-sm" placeholder="Remarks (optional)" value="{{ $remark }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-users-slash fa-3x mb-3" style="color: #cbd5e1;"></i>
                    <p class="fw-bold mb-1">No students enrolled in this class</p>
                    <small><a href="{{ route('classes.enroll.show', $class) }}" class="text-primary fw-bold">Enroll students</a> to record attendance.</small>
                </div>
                @endif
            </div>
            @if($class->students->isNotEmpty())
            <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 py-2">
                    <i class="fas fa-save"></i> Save Attendance Sheet
                </button>
            </div>
            @endif
        </div>
    </form>
</div>

<script>
function markAll(status) {
    document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(radio => {
        radio.checked = true;
    });
}
</script>
@endsection
