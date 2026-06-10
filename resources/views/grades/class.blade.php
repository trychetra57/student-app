@extends('layouts.app')

@section('title', 'Manage Grades - ' . $class->name)

@section('content')
<div class="container-lg">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-file-signature text-primary"></i> Record Class Grades</h1>
            <p class="text-muted mb-0">Class: <strong>{{ $class->name }}</strong> · Teacher: <strong>{{ $class->teacher->name ?? 'N/A' }}</strong></p>
        </div>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('grades.store', $class) }}">
        @csrf
        <div class="card">
            <div class="card-header"><i class="fas fa-edit text-primary"></i> Grade Sheet</div>
            <div class="card-body p-0">
                @if($class->students->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th style="width: 150px;">Quiz (0-100)</th>
                                <th style="width: 150px;">Midterm (0-100)</th>
                                <th style="width: 150px;">Final (0-100)</th>
                                <th>Remarks / Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $student)
                            @php
                                $studentGrades = $existing->get($student->id) ? $existing->get($student->id)->keyBy('exam_type') : collect();
                                $quiz = $studentGrades->get('Quiz');
                                $midterm = $studentGrades->get('Midterm');
                                $final = $studentGrades->get('Final');
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $student->name }}</td>
                                <td>
                                    <input type="number" step="0.01" min="0" max="100" name="grades[{{ $student->id }}][Quiz][score]" class="form-control form-control-sm" placeholder="Score" value="{{ $quiz ? $quiz->score : '' }}">
                                    <input type="hidden" name="grades[{{ $student->id }}][Quiz][remarks]" value="">
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0" max="100" name="grades[{{ $student->id }}][Midterm][score]" class="form-control form-control-sm" placeholder="Score" value="{{ $midterm ? $midterm->score : '' }}">
                                    <input type="hidden" name="grades[{{ $student->id }}][Midterm][remarks]" value="">
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0" max="100" name="grades[{{ $student->id }}][Final][score]" class="form-control form-control-sm" placeholder="Score" value="{{ $final ? $final->score : '' }}">
                                    <input type="hidden" name="grades[{{ $student->id }}][Final][remarks]" value="">
                                </td>
                                <td>
                                    <input type="text" name="grades[{{ $student->id }}][Final][remarks]" class="form-control form-control-sm" placeholder="Add optional remarks…" value="{{ $final ? $final->remarks : ($midterm ? $midterm->remarks : ($quiz ? $quiz->remarks : '')) }}">
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
                    <small><a href="{{ route('classes.enroll.show', $class) }}" class="text-primary fw-bold">Enroll students</a> to record grades.</small>
                </div>
                @endif
            </div>
            @if($class->students->isNotEmpty())
            <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 py-2">
                    <i class="fas fa-save"></i> Save Grades
                </button>
            </div>
            @endif
        </div>
    </form>
</div>
@endsection
