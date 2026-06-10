@extends('layouts.app')

@section('title', 'Academic Transcript - ' . $student->name)

@section('styles')
<style>
@media print {
    .sidebar, .topbar, .footer, .btn, .no-print {
        display: none !important;
    }
    .main-wrap {
        margin-left: 0 !important;
        padding-top: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
        margin-bottom: 0 !important;
    }
    body {
        background: white !important;
        color: black !important;
    }
    .container-lg {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
    }
}
</style>
@endsection

@section('content')
<div class="container-lg">
    <div class="page-header no-print">
        <div>
            <h1 class="page-title"><i class="fas fa-file-alt text-primary"></i> Academic Transcript</h1>
            <p class="text-muted mb-0">Official academic record for <strong>{{ $student->name }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Transcript
            </button>
            <a href="{{ route('grades.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Official Transcript Document Card --}}
    <div class="card p-5" style="border: 1px solid #e2e8f0; background: white;">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
            <div>
                <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">LEARN ACADEMY</h2>
                <div class="text-muted" style="font-size: 0.85rem;">Official Academic Record & Transcript</div>
            </div>
            <div class="text-end">
                <div class="fw-semibold text-dark">Date Issued:</div>
                <div class="text-muted" style="font-size: 0.85rem;">{{ now()->format('M d, Y') }}</div>
            </div>
        </div>

        {{-- Student Info Block --}}
        <div class="row g-3 mb-5">
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0" style="font-size: 0.85rem;">
                    <tr>
                        <td class="text-muted py-1" style="width: 120px;">Student Name:</td>
                        <td class="fw-bold text-dark py-1">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted py-1">Student ID:</td>
                        <td class="fw-semibold text-dark py-1">#{{ $student->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted py-1">Email Address:</td>
                        <td class="text-dark py-1">{{ $student->email }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0" style="font-size: 0.85rem;">
                    <tr>
                        <td class="text-muted py-1" style="width: 120px;">Grade Level:</td>
                        <td class="fw-semibold text-dark py-1">{{ $student->grade }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted py-1">Status:</td>
                        <td class="py-1">{!! $student->status_badge !!}</td>
                    </tr>
                    <tr>
                        <td class="text-muted py-1">Enrollment Date:</td>
                        <td class="text-dark py-1">{{ $student->created_at->format('M d, Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Transcript Grades Table --}}
        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-book-open text-primary me-2"></i> Course & Grade History</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th>Class / Course Code</th>
                        <th>Instructor</th>
                        <th class="text-center" style="width: 110px;">Quiz Avg</th>
                        <th class="text-center" style="width: 110px;">Midterm</th>
                        <th class="text-center" style="width: 110px;">Final Exam</th>
                        <th class="text-center" style="width: 110px;">Letter Grade</th>
                        <th class="text-center" style="width: 100px;">GPA Points</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($transcriptData) > 0)
                        @foreach($transcriptData as $data)
                            @php
                                $quiz = $data['grades']->where('exam_type', 'Quiz')->first();
                                $midterm = $data['grades']->where('exam_type', 'Midterm')->first();
                                $final = $data['grades']->where('exam_type', 'Final')->first();
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $data['class']->name }}</div>
                                    <small class="text-muted">Room: {{ $data['class']->room_number ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $data['class']->teacher->name ?? 'N/A' }}</td>
                                <td class="text-center fw-semibold text-muted">{{ $quiz ? number_format($quiz->score, 2) : '—' }}</td>
                                <td class="text-center fw-semibold text-muted">{{ $midterm ? number_format($midterm->score, 2) : '—' }}</td>
                                <td class="text-center fw-bold text-dark">{{ $final ? number_format($final->score, 2) : '—' }}</td>
                                <td class="text-center fw-bold">
                                    <span class="badge {{ $data['letter_grade'] === 'F' ? 'bg-danger' : 'bg-success' }} px-3 py-1">
                                        {{ $data['letter_grade'] }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold text-dark">{{ number_format($data['points'], 1) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No course registration or grade data found for this student.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-3 justify-content-end mb-5">
            <div class="col-sm-5 col-md-4">
                <div class="card p-3 shadow-none" style="border: 1.5px solid #cbd5e1; background: #f8fafc; border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted fw-semibold" style="font-size: 0.8rem; text-transform: uppercase;">Courses Completed</span>
                        <span class="fw-bold text-dark" style="font-size: 1.1rem;">{{ count(array_filter($transcriptData, fn($d) => $d['avg_score'] !== null)) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="text-muted fw-semibold" style="font-size: 0.8rem; text-transform: uppercase;">Cumulative GPA</span>
                        <span class="fw-extrabold text-primary" style="font-size: 1.4rem;">{{ number_format($cgpa, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Official Sign Off --}}
        <div class="d-flex justify-content-between align-items-end mt-5 pt-4 border-top" style="font-size: 0.82rem;">
            <div>
                <div class="fw-semibold text-dark">LEARN Academy Administration Office</div>
                <div class="text-muted">This transcript is official only when signed and sealed.</div>
            </div>
            <div class="text-center" style="width: 200px;">
                <div style="border-bottom: 1.5px solid #cbd5e1; height: 50px;" class="mb-2"></div>
                <div class="fw-bold text-dark">Registrar Signature</div>
            </div>
        </div>
    </div>
</div>
@endsection
