<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDocument;
use App\Mail\StudentWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WebStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->with('documents');

        // Full-text search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('name',    'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")
                ->orWhere('phone', 'like', "%$s%")
                ->orWhere('grade', 'like', "%$s%")
                ->orWhere('address','like',"%$s%")
            );
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Grade filter
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sort      = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $allowed   = ['name','email','grade','status','created_at'];
        if (in_array($sort, $allowed)) {
            $query->orderBy($sort, $direction);
        }

        $perPage  = $request->get('per_page', 10);
        $students = $query->paginate($perPage)->withQueryString();

        // Sidebar counts (unfiltered)
        $activeCount    = Student::where('status','active')->count();
        $inactiveCount  = Student::where('status','inactive')->count();
        $graduatedCount = Student::where('status','graduated')->count();

        // Grade list for filter dropdown
        $grades = Student::whereNotNull('grade')->distinct()->orderBy('grade')->pluck('grade');

        return view('index', compact('students','activeCount','inactiveCount','graduatedCount','grades'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:students,email',
            'phone'          => 'nullable|string|max:50',
            'grade'          => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:500',
            'date_of_birth'  => 'nullable|date|before:today',
            'guardian_name'  => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:50',
            'status'         => 'nullable|in:active,inactive,graduated',
            'profile_picture'=> 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data['status'] = $data['status'] ?? 'active';

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('student_profiles', 'public');
        }

        $student = Student::create($data);

        // Send welcome email (gracefully fails if mail not configured)
        try {
            Mail::to($student->email)->send(new StudentWelcomeMail($student));
        } catch (\Exception $e) {
            // Silent fail — mail not configured
        }

        return redirect()->route('students.index')->with('success', "Student '{$student->name}' added successfully!");
    }

    public function show(Student $student)
    {
        $student->load('documents');
        return view('show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:students,email,'.$student->id,
            'phone'          => 'nullable|string|max:50',
            'grade'          => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:500',
            'date_of_birth'  => 'nullable|date|before:today',
            'guardian_name'  => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:50',
            'status'         => 'sometimes|required|in:active,inactive,graduated',
            'profile_picture'=> 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('student_profiles', 'public');
        } elseif ($request->has('remove_profile_picture') && $request->remove_profile_picture == 'true') {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
                $data['profile_picture'] = null;
            }
        }

        $student->update($data);
        return redirect()->route('students.show', $student)->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }

    public function deleteAll()
    {
        if (!auth()->user()->isSuperAdmin()) abort(403, 'Only Super Admin can delete all students');
        $count = Student::count();
        // Use each()->delete() so SoftDeletes trait sets deleted_at correctly
        Student::each(fn($s) => $s->delete());
        return redirect()->route('students.index')->with('success', "Deleted all {$count} students.");
    }

    public function bulkDelete(Request $request)
    {
        if (!auth()->user()->isAdmin()) abort(403, 'Unauthorized access');
        $ids = $request->input('student_ids', []);
        if (empty($ids)) return redirect()->back()->with('error','No students selected.');
        $count = Student::whereIn('id', $ids)->delete();
        return redirect()->route('students.index')->with('success', "{$count} student(s) deleted.");
    }

    public function bulkForceDelete(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) abort(403, 'Only Super Admin can force delete students');
        $ids = $request->input('student_ids', []);
        if (empty($ids)) return redirect()->back()->with('error','No students selected.');
        $students = Student::withTrashed()->whereIn('id', $ids)->get();
        foreach ($students as $s) {
            foreach ($s->documents as $doc) {
                Storage::delete($doc->file_path);
                $doc->delete();
            }
            $s->forceDelete();
        }
        return redirect()->route('students.index')->with('success', count($ids)." student(s) permanently deleted.");
    }

    public function bulkUpdateStatus(Request $request)
    {
        $ids    = $request->input('student_ids', []);
        $status = $request->input('status');
        if (empty($ids) || !$status) return redirect()->back()->with('error','Invalid request.');
        Student::whereIn('id', $ids)->update(['status' => $status]);
        return redirect()->route('students.index')->with('success', count($ids)." student(s) set to {$status}.");
    }

    public function uploadDocument(Request $request, Student $student)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'type'     => 'required|string|max:50',
        ]);
        $file = $request->file('document');
        $path = $file->store('student_documents/'.$student->id);
        $student->documents()->create([
            'file_path'     => $path,
            'file_name'     => $file->getClientOriginalName(),
            'file_type'     => $file->getClientOriginalExtension(),
            'document_type' => $request->type,
            'uploaded_by'   => auth()->id(),
        ]);
        return redirect()->route('students.show', $student)->with('success','Document uploaded.');
    }

    public function downloadDocument(\App\Models\StudentDocument $document)
    {
        return Storage::download($document->file_path, $document->file_name);
    }

    public function deleteDocument(\App\Models\StudentDocument $document)
    {
        $student = $document->student;
        Storage::delete($document->file_path);
        $document->delete();
        return redirect()->route('students.show', $student)->with('success','Document deleted.');
    }

    public function export(Request $request)
    {
        $query = Student::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name','like',"%$s%")->orWhere('email','like',"%$s%")->orWhere('phone','like',"%$s%"));
        }
        if ($request->filled('status') && $request->status !== 'all') $query->where('status', $request->status);
        if ($request->filled('grade')) $query->where('grade', $request->grade);
        $students = $query->get();
        $filename = 'students_'.date('Y-m-d_H-i-s').'.csv';

        return response()->streamDownload(function() use ($students) {
            $f = fopen('php://output','w');
            fputcsv($f,['ID','Name','Email','Phone','Grade','Address','Date of Birth','Guardian Name','Guardian Phone','Status','Created At']);
            foreach ($students as $s) {
                fputcsv($f,[$s->id,$s->name,$s->email,$s->phone,$s->grade,$s->address,
                    $s->date_of_birth?\Carbon\Carbon::parse($s->date_of_birth)->format('Y-m-d'):'',
                    $s->guardian_name,$s->guardian_phone,$s->status,
                    $s->created_at?$s->created_at->format('Y-m-d H:i:s'):'']);
            }
            fclose($f);
        }, $filename, ['Content-Type'=>'text/csv']);
    }

    public function dashboard()
    {
        $stats = [
            'total_students'     => Student::count(),
            'active_students'    => Student::where('status','active')->count(),
            'inactive_students'  => Student::where('status','inactive')->count(),
            'graduated_students' => Student::where('status','graduated')->count(),
            'new_this_month'     => Student::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count(),
            'total_documents'    => StudentDocument::count(),
            'total_classes'      => \App\Models\SchoolClass::count(),
            'active_staffs'      => \App\Models\User::whereIn('role', ['staff', 'teacher'])->count(),
            'system_logs'        => \App\Models\AuditLog::count(),
            'daily_phone_logs'   => 0,
            'daily_enquiries'    => 0,
            'daily_postal_exchanges' => 0,
        ];

        $gradeStats = Student::selectRaw('grade, count(*) as count')
            ->whereNotNull('grade')->groupBy('grade')->orderByDesc('count')->get();

        // Monthly enrollment for the last 12 months
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'count' => Student::whereMonth('created_at', $date->month)
                                  ->whereYear('created_at', $date->year)->count(),
            ];
        }

        return view('dashboard', compact('stats','gradeStats','monthlyData'));
    }
}
