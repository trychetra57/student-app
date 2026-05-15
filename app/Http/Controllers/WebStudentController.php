<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->with('documents');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('grade', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $sort      = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        $perPage  = $request->get('per_page', 10);
        $students = $query->paginate($perPage)->withQueryString();

        return view('index', compact('students'));
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
        ]);

        $data['status'] = $data['status'] ?? 'active';
        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
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
            'email'          => 'required|email|unique:students,email,' . $student->id,
            'phone'          => 'nullable|string|max:50',
            'grade'          => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:500',
            'date_of_birth'  => 'nullable|date|before:today',
            'guardian_name'  => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:50',
            'status'         => 'sometimes|required|in:active,inactive,graduated',
        ]);

        $student->update($data);

        return redirect()->route('students.show', $student)->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    public function deleteAll()
    {
        $count = Student::count();
        Student::query()->delete();
        return redirect()->route('students.index')->with('success', "Successfully deleted all {$count} students.");
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('student_ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No students selected.');
        }
        $count = Student::whereIn('id', $ids)->delete();
        return redirect()->route('students.index')->with('success', "{$count} student(s) deleted successfully.");
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('student_ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No students selected.');
        }
        $students = Student::withTrashed()->whereIn('id', $ids)->get();
        foreach ($students as $student) {
            foreach ($student->documents as $doc) {
                Storage::delete($doc->file_path);
                $doc->delete();
            }
            $student->forceDelete();
        }
        return redirect()->route('students.index')->with('success', count($ids) . " student(s) permanently deleted.");
    }

    public function bulkUpdateStatus(Request $request)
    {
        $ids    = $request->input('student_ids', []);
        $status = $request->input('status');

        if (empty($ids) || !$status) {
            return redirect()->back()->with('error', 'No students selected or status not specified.');
        }

        Student::whereIn('id', $ids)->update(['status' => $status]);
        return redirect()->route('students.index')->with('success', count($ids) . " student(s) status updated to {$status}.");
    }

    public function uploadDocument(Request $request, Student $student)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'type'     => 'required|string|max:50',
        ]);

        $file = $request->file('document');
        $path = $file->store('student_documents/' . $student->id);

        $student->documents()->create([
            'file_path'     => $path,
            'file_name'     => $file->getClientOriginalName(),
            'file_type'     => $file->getClientOriginalExtension(),
            'document_type' => $request->type,
            'uploaded_by'   => auth()->id(),
        ]);

        return redirect()->route('students.show', $student)
                         ->with('success', 'Document uploaded successfully.');
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

        return redirect()->route('students.show', $student)
                         ->with('success', 'Document deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Student::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $students = $query->get();
        $filename = 'students_' . date('Y-m-d_H-i-s') . '.csv';

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Grade', 'Address', 'Date of Birth', 'Guardian Name', 'Guardian Phone', 'Status', 'Created At']);
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->phone,
                    $student->grade,
                    $student->address,
                    $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d') : '',
                    $student->guardian_name,
                    $student->guardian_phone,
                    $student->status,
                    $student->created_at ? $student->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function dashboard()
    {
        $stats = [
            'total_students'     => Student::count(),
            'active_students'    => Student::where('status', 'active')->count(),
            'inactive_students'  => Student::where('status', 'inactive')->count(),
            'graduated_students' => Student::where('status', 'graduated')->count(),
            'new_this_month'     => Student::whereMonth('created_at', now()->month)
                                           ->whereYear('created_at', now()->year)
                                           ->count(),
            'total_documents'    => \App\Models\StudentDocument::count(),
        ];

        $gradeStats = Student::selectRaw('grade, count(*) as count')
                             ->whereNotNull('grade')
                             ->groupBy('grade')
                             ->orderByDesc('count')
                             ->get();

        return view('dashboard', compact('stats', 'gradeStats'));
    }
}
