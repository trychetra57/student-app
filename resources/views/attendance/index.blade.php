@extends('layouts.app')

@section('title', 'Attendance - LEARN Academy Admin')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-calendar-check text-primary"></i> Attendance Management</h1>
            <p class="text-muted mb-0 font-medium">Select a class to record or view attendance</p>
        </div>
    </div>

    {{-- Stats cards row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #125875, #1583b1); color: white;">
                <div class="card-body py-4 position-relative overflow-hidden">
                    <div style="font-size: 0.85rem; opacity: 0.85; font-weight: 600; text-transform: uppercase;">Active Students</div>
                    <div class="display-6 fw-bold mt-2">{{ $totalStudents }}</div>
                    <i class="fas fa-user-graduate position-absolute" style="right: 15px; bottom: 15px; font-size: 2.2rem; opacity: 0.15;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #01aa59, #10b981); color: white;">
                <div class="card-body py-4 position-relative overflow-hidden">
                    <div style="font-size: 0.85rem; opacity: 0.85; font-weight: 600; text-transform: uppercase;">Present Today</div>
                    <div class="display-6 fw-bold mt-2">{{ $presentToday }}</div>
                    <i class="fas fa-check-circle position-absolute" style="right: 15px; bottom: 15px; font-size: 2.2rem; opacity: 0.15;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ff7350, #fca5a5); color: white;">
                <div class="card-body py-4 position-relative overflow-hidden">
                    <div style="font-size: 0.85rem; opacity: 0.85; font-weight: 600; text-transform: uppercase;">Absent Today</div>
                    <div class="display-6 fw-bold mt-2">{{ $absentToday }}</div>
                    <i class="fas fa-times-circle position-absolute" style="right: 15px; bottom: 15px; font-size: 2.2rem; opacity: 0.15;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #8b5cf6, #c084fc); color: white;">
                <div class="card-body py-4 position-relative overflow-hidden">
                    <div style="font-size: 0.85rem; opacity: 0.85; font-weight: 600; text-transform: uppercase;">Late Today</div>
                    <div class="display-6 fw-bold mt-2">{{ $lateToday }}</div>
                    <i class="fas fa-clock position-absolute" style="right: 15px; bottom: 15px; font-size: 2.2rem; opacity: 0.15;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Classes List --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-door-open text-primary"></i> Active Classes</div>
        <div class="card-body p-0">
            @if($classes->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Room</th>
                            <th>Teacher</th>
                            <th class="text-center">Enrolled Students</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px; height:36px; background:#e6f2f7; color:#125875; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:700;">
                                        {{ strtoupper(substr($class->name, 0, 2)) }}
                                    </div>
                                    <div class="fw-bold">{{ $class->name }}</div>
                                </div>
                            </td>
                            <td>{{ $class->room_number ?? '—' }}</td>
                            <td>
                                @if($class->teacher)
                                    <div class="fw-semibold">{{ $class->teacher->name }}</div>
                                    <small class="text-muted">{{ $class->teacher->subject ?? '' }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary rounded-pill px-3">{{ $class->students_count }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('attendance.sheet', $class) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-calendar-check"></i> Attendance Sheet
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-door-closed fa-3x mb-3" style="color: #cbd5e1;"></i>
                <p class="fw-bold mb-1">No active classes found</p>
                <small>Create an active class with students first before taking attendance.</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
