@extends('layouts.app')

@section('title', 'Grades & Transcripts - LEARN Academy Admin')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-file-signature text-primary"></i> Grades & Transcripts</h1>
            <p class="text-muted mb-0">Record exam scores or generate official student transcripts</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left: Classes List for Grade Entry --}}
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-door-open text-primary"></i> Record Class Grades</div>
                <div class="card-body p-0">
                    @if($classes->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Teacher</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classes as $class)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $class->name }}</div>
                                        <small class="text-muted">Room: {{ $class->room_number ?? '—' }} · Students: {{ $class->students_count }}</small>
                                    </td>
                                    <td>
                                        @if($class->teacher)
                                            <div class="fw-semibold">{{ $class->teacher->name }}</div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('grades.class', $class) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit Grades
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-folder-open fa-3x mb-3" style="color:#cbd5e1;"></i>
                        <p class="fw-bold mb-1">No active classes found</p>
                        <small>Create an active class to record grades.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Students List for Transcripts --}}
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user-graduate text-primary"></i> Student Transcripts</span>
                    <form method="GET" action="{{ route('grades.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search student name…" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="card-body p-0">
                    @if($students->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Grade Level</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td class="fw-bold">{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->grade }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('students.transcript', $student) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-file-alt"></i> View Transcript
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($students->hasPages())
                    <div class="px-3 py-2 border-top">
                        {{ $students->links() }}
                    </div>
                    @endif
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-users-slash fa-3x mb-3" style="color:#cbd5e1;"></i>
                        <p class="fw-bold mb-1">No students found</p>
                        <small>Add students to the database to view transcripts.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
