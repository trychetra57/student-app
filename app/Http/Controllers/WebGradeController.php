<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;

class WebGradeController extends Controller
{
    public function index(Request $request)
    {
        $queryClasses = SchoolClass::withCount('students')->where('status', 'active')->orderBy('name');
        $classes = $queryClasses->get();

        $queryStudents = Student::query();
        if ($request->filled('search')) {
            $queryStudents->search($request->search);
        }
        $students = $queryStudents->active()->orderBy('name')->paginate(10)->withQueryString();

        return view('grades.index', compact('classes', 'students'));
    }

    public function classGrades(SchoolClass $class)
    {
        $class->load(['students' => function ($query) {
            $query->orderBy('name');
        }]);

        // Get existing grades for this class
        $existing = Grade::where('school_class_id', $class->id)
            ->get()
            ->groupBy('student_id');

        return view('grades.class', compact('class', 'existing'));
    }

    public function saveGrades(Request $request, SchoolClass $class)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*.*.score' => 'nullable|numeric|min:0|max:100',
            'grades.*.*.remarks' => 'nullable|string|max:255',
        ]);

        $gradesData = $request->input('grades');

        foreach ($gradesData as $studentId => $exams) {
            foreach ($exams as $examType => $details) {
                if (isset($details['score']) && $details['score'] !== '') {
                    Grade::updateOrCreate(
                        [
                            'school_class_id' => $class->id,
                            'student_id' => $studentId,
                            'exam_type' => $examType,
                        ],
                        [
                            'score' => $details['score'],
                            'remarks' => $details['remarks'] ?? null,
                        ]
                    );
                } else {
                    // If empty, delete the record if it exists
                    Grade::where('school_class_id', $class->id)
                        ->where('student_id', $studentId)
                        ->where('exam_type', $examType)
                        ->delete();
                }
            }
        }

        return redirect()->route('grades.class', $class)
            ->with('success', 'Grades updated successfully!');
    }

    public function studentTranscript(Student $student)
    {
        $student->load(['classes.teacher', 'grades']);

        // Group grades by class
        $classGrades = $student->grades->groupBy('school_class_id');

        // Calculate GPA: map scores to GPA points: A=4.0, B=3.0, C=2.0, D=1.0, F=0.0
        // We'll calculate class-average score first, map it to letter grade, and get GPA
        $totalClasses = 0;
        $totalPoints = 0.0;
        $transcriptData = [];

        foreach ($student->classes as $class) {
            $grades = $classGrades->get($class->id) ?? collect();
            $avgScore = $grades->avg('score');
            
            if ($avgScore !== null) {
                $totalClasses++;
                $letter = 'F';
                $pts = 0.0;
                if ($avgScore >= 90) { $letter = 'A'; $pts = 4.0; }
                elseif ($avgScore >= 80) { $letter = 'B'; $pts = 3.0; }
                elseif ($avgScore >= 70) { $letter = 'C'; $pts = 2.0; }
                elseif ($avgScore >= 60) { $letter = 'D'; $pts = 1.0; }
                
                $totalPoints += $pts;
                $transcriptData[] = [
                    'class' => $class,
                    'avg_score' => $avgScore,
                    'letter_grade' => $letter,
                    'points' => $pts,
                    'grades' => $grades,
                ];
            } else {
                $transcriptData[] = [
                    'class' => $class,
                    'avg_score' => null,
                    'letter_grade' => 'N/A',
                    'points' => 0.0,
                    'grades' => collect(),
                ];
            }
        }

        $cgpa = $totalClasses > 0 ? round($totalPoints / $totalClasses, 2) : 0.00;

        return view('grades.transcript', compact('student', 'transcriptData', 'cgpa'));
    }
}
