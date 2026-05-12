<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('grade', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $query = $query->sort($sort, $direction);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $students = $query->paginate($perPage)->withQueryString();

        return view('index', compact('students'));
    }

    public function dashboard()
    {
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::active()->count(),
            'inactive_students' => Student::inactive()->count(),
            'graduated_students' => Student::graduated()->count(),
            'new_this_month' => Student::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
        ];

        $gradeStats = Student::select('grade', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                             ->whereNotNull('grade')
                             ->groupBy('grade')
                             ->get();

        $recentStudents = Student::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('stats', 'gradeStats', 'recentStudents'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive,graduated',
        ]);

        // Set default status if not provided
        $data['status'] = $data['status'] ?? 'active';

        $student = Student::create($data);

        // Log the creation
        $this->logAudit('create', $student, null, $data);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        return view('show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $oldValues = $student->toArray();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,graduated',
        ]);

        $student->update($data);

        // Log the update
        $this->logAudit('update', $student, $oldValues, $data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $oldValues = $student->toArray();

        $student->delete();

        // Log the deletion
        $this->logAudit('delete', $student, $oldValues, null);

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function forceDelete($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $oldValues = $student->toArray();

        // Delete associated documents first
        foreach ($student->documents as $document) {
            \Illuminate\Support\Facades\Storage::delete($document->file_path);
            $document->delete();
        }

        $student->forceDelete();

        // Log the permanent deletion
        $this->logAudit('force_delete', $student, $oldValues, null);

        return redirect()->route('students.index')->with('success', 'Student permanently deleted.');
    }

    // Bulk actions
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('student_ids', []);
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        $students = Student::whereIn('id', $ids)->get();

        foreach ($students as $student) {
            $oldValues = $student->toArray();
            $student->delete();
            $this->logAudit('delete', $student, $oldValues, null);
        }

        return redirect()->back()->with('success', count($ids) . ' students deleted successfully.');
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('student_ids', []);
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        $students = Student::withTrashed()->whereIn('id', $ids)->get();

        foreach ($students as $student) {
            $oldValues = $student->toArray();
            
            // Delete associated documents
            foreach ($student->documents as $document) {
                \Illuminate\Support\Facades\Storage::delete($document->file_path);
                $document->delete();
            }

            $student->forceDelete();
            $this->logAudit('force_delete', $student, $oldValues, null);
        }

        return redirect()->back()->with('success', count($ids) . ' students permanently deleted.');
    }

    public function deleteAll()
    {
        $students = Student::all();
        $count = $students->count();
        
        foreach ($students as $student) {
            $oldValues = $student->toArray();
            $student->delete();
            $this->logAudit('delete', $student, $oldValues, null);
        }

        return redirect()->back()->with('success', "Successfully deleted all {$count} students.");
    }

    public function bulkUpdateStatus(Request $request)
    {
        $ids = $request->input('student_ids', []);
        $status = $request->input('status');

        if (empty($ids) || !$status) {
            return redirect()->back()->with('error', 'No students selected or status not specified.');
        }

        $students = Student::whereIn('id', $ids)->get();
        foreach ($students as $student) {
            $oldValues = $student->toArray();
            $student->update(['status' => $status]);
            $this->logAudit('update', $student, $oldValues, ['status' => $status]);
        }

        return redirect()->back()->with('success', count($ids) . ' students updated successfully.');
    }

    // Export functionality
    public function export(Request $request)
    {
        $query = Student::query();

        // Apply same filters as index
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
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
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($students) {
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
                    $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '',
                    $student->guardian_name,
                    $student->guardian_phone,
                    $student->status,
                    $student->created_at ? $student->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    public function uploadDocument(Request $request, Student $student)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'type' => 'required|string|max:50',
        ]);

        $file = $request->file('document');
        $path = $file->store('student_documents/' . $student->id);

        $student->documents()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'document_type' => $request->type,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function downloadDocument(\App\Models\StudentDocument $document)
    {
        return Storage::download($document->file_path, $document->file_name);
    }

    public function deleteDocument(\App\Models\StudentDocument $document)
    {
        $oldValues = $document->toArray();
        $student = $document->student;

        \Illuminate\Support\Facades\Storage::delete($document->file_path);
        $document->delete();

        // Log the deletion of the document under the student's audit trail
        $this->logAudit('delete_document', $student, $oldValues, null);

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    // Private helper method for audit logging
    private function logAudit($action, $model, $oldValues = null, $newValues = null)
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
