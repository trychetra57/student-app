@extends('layouts.app')

@section('title', 'Enroll Students - ' . $class->name)

@section('content')
<div class="container-lg">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-user-plus text-primary"></i> Class Enrollment</h1>
            <p class="text-muted mb-0">Manage student enrollment for <strong>{{ $class->name }}</strong> (Room: {{ $class->room_number ?? 'N/A' }} · Capacity: {{ $class->capacity }})</p>
        </div>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Classes
        </a>
    </div>

    <div class="row g-4">
        {{-- Left: Current Enrolled Students --}}
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-users text-primary"></i> Currently Enrolled Students ({{ $class->students->count() }})
                </div>
                <div class="card-body p-0">
                    @if($class->students->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->students as $student)
                                <tr>
                                    <td class="text-muted">#{{ $student->id }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $student->name }}</div>
                                        <small class="text-muted">{{ $student->phone }}</small>
                                    </td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->grade }}</td>
                                    <td>{!! $student->status_badge !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-user-slash fa-3x mb-3" style="color: #cbd5e1;"></i>
                        <p class="fw-bold mb-1">No students enrolled yet</p>
                        <small>Use the panel on the right to enroll students.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Enroll New Students Form --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-plus text-success"></i> Enroll Students
                </div>
                <div class="card-body">
                    @if($availableStudents->isNotEmpty())
                    <form method="POST" action="{{ route('classes.enroll.store', $class) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label mb-2">Select Students to Enroll</label>
                            <div class="border rounded-3 p-3" style="max-height: 320px; overflow-y: auto; background: #f8fafc;">
                                @foreach($availableStudents as $student)
                                <div class="form-check py-2 border-bottom last-border-0">
                                    <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="student_{{ $student->id }}">
                                    <label class="form-check-label d-block" for="student_{{ $student->id }}">
                                        <div class="fw-semibold text-dark">{{ $student->name }}</div>
                                        <small class="text-muted">{{ $student->email }} · {{ $student->grade }}</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-2">Only showing active students not currently enrolled in this class.</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Enroll Selected Students
                        </button>
                    </form>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-check-double fa-2x mb-2 text-success"></i>
                        <p class="fw-semibold mb-0">All active students are already enrolled.</p>
                        <small>No additional students available to enroll.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.last-border-0:last-child {
    border-bottom: 0 !important;
}
</style>
@endsection
