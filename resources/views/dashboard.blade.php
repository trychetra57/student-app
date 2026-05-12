@extends('layouts.app')

@section('title', 'Dashboard - Student Management')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('students.export') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export Data
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $stats['total_students'] }}</h3>
                            <small class="text-muted">Total Students</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $stats['active_students'] }}</h3>
                            <small class="text-muted">Active Students</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $stats['graduated_students'] }}</h3>
                            <small class="text-muted">Graduated</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $stats['new_this_month'] }}</h3>
                            <small class="text-muted">New This Month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Grade Distribution -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-pie"></i> Students by Grade
                </div>
                <div class="card-body">
                    @if($gradeStats->isNotEmpty())
                        <canvas id="gradeChart" width="400" height="300"></canvas>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-pie fa-3x mb-3"></i>
                            <p>No grade data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-bar"></i> Students by Status
                </div>
                <div class="card-body">
                    <canvas id="statusChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Students -->
    <div class="card mt-4">
        <div class="card-header">
            <i class="fas fa-clock"></i> Recent Students
        </div>
        <div class="card-body">
            @if($recentStudents->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentStudents as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->grade ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $student->status == 'active' ? 'bg-success' : ($student->status == 'inactive' ? 'bg-warning' : 'bg-info') }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td>{{ $student->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <p>No students found</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grade Distribution Chart
    @if($gradeStats->isNotEmpty())
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
        type: 'doughnut',
        data: {
            labels: @json($gradeStats->pluck('grade')),
            datasets: [{
                data: @json($gradeStats->pluck('count')),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    @endif

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Inactive', 'Graduated'],
            datasets: [{
                label: 'Students',
                data: [
                    {{ $stats['active_students'] }},
                    {{ $stats['inactive_students'] }},
                    {{ $stats['graduated_students'] }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#17a2b8'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>

<style>
.stats-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.bg-primary { background-color: #007bff !important; }
.bg-success { background-color: #28a745 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-info { background-color: #17a2b8 !important; }
</style>
@endsection