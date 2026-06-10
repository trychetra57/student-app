<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::withCount('students')->where('status', 'active')->orderBy('name')->get();
        
        // General stats
        $totalStudents = Student::active()->count();
        $today = Carbon::today()->toDateString();
        
        $presentToday = Attendance::where('attendance_date', $today)->where('status', 'present')->count();
        $absentToday = Attendance::where('attendance_date', $today)->where('status', 'absent')->count();
        $lateToday = Attendance::where('attendance_date', $today)->where('status', 'late')->count();
        
        return view('attendance.index', compact('classes', 'totalStudents', 'presentToday', 'absentToday', 'lateToday'));
    }

    public function showSheet(Request $request, SchoolClass $class)
    {
        $dateStr = $request->get('date', Carbon::today()->toDateString());
        $date = Carbon::parse($dateStr);
        
        $class->load(['students' => function ($query) {
            $query->orderBy('name');
        }]);

        // Get existing attendance for this class and date
        $existing = Attendance::where('school_class_id', $class->id)
            ->where('attendance_date', $dateStr)
            ->get()
            ->keyBy('student_id');

        return view('attendance.sheet', compact('class', 'date', 'existing'));
    }

    public function saveSheet(Request $request, SchoolClass $class)
    {
        $dateStr = $request->input('date', Carbon::today()->toDateString());
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late,excused',
            'remarks' => 'nullable|array',
            'remarks.*' => 'nullable|string|max:255',
        ]);

        $attendances = $request->input('attendance');
        $remarks = $request->input('remarks', []);

        foreach ($attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'school_class_id' => $class->id,
                    'student_id' => $studentId,
                    'attendance_date' => $dateStr,
                ],
                [
                    'status' => $status,
                    'remarks' => $remarks[$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('attendance.sheet', [$class, 'date' => $dateStr])
            ->with('success', 'Attendance sheet saved successfully!');
    }
}
