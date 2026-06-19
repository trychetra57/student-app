<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentDocument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->with('documents');

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
        
        // Handle sorting manually if no macro exists
        $query->orderBy($sort, $direction);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $students = $query->paginate($perPage)->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    public function dashboard()
    {
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'inactive_students' => Student::where('status', 'inactive')->count(),
            'graduated_students' => Student::where('status', 'graduated')->count(),
            'new_this_month' => Student::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
            'total_users' => User::count(),
            'total_documents' => StudentDocument::count(),
            'total_audit_logs' => AuditLog::count(),
            // Placeholders for features not yet implemented to match UI request
            'fees_collection' => 0,
            'banks' => 0,
            'classes' => SchoolClass::count(),
            'hostels' => 0,
            'exam_results' => 0,
            'events' => 0,
        ];

        $recentStudents = Student::orderBy('created_at', 'desc')->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recentStudents' => $recentStudents,
            ]
        ]);
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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['status'] = $data['status'] ?? 'active';

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('student_profiles', 'public');
        }

        $student = Student::create($data);

        $this->logAudit('create', $student, null, $data);

        return response()->json([
            'success' => true,
            'message' => 'Student added successfully.',
            'data' => $student
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json([
            'success' => true,
            'data' => $student->load('documents')
        ]);
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
            'status' => 'sometimes|required|in:active,inactive,graduated',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        
        $student->load('documents');

        $this->logAudit('update', $student, $oldValues, $data);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => $student
        ]);
    }

    public function destroy(Student $student)
    {
        $oldValues = $student->toArray();
        $student->delete();

        $this->logAudit('delete', $student, $oldValues, null);

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.'
        ]);
    }

    public function forceDelete($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $oldValues = $student->toArray();

        foreach ($student->documents as $document) {
            Storage::delete($document->file_path);
            $document->delete();
        }

        if ($student->profile_picture) {
            Storage::disk('public')->delete($student->profile_picture);
        }

        $student->forceDelete();

        $this->logAudit('force_delete', $student, $oldValues, null);

        return response()->json([
            'success' => true,
            'message' => 'Student permanently deleted.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('student_ids', []);
        
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No students selected.'], 400);
        }

        $students = Student::whereIn('id', $ids)->get();
        foreach ($students as $student) {
            $oldValues = $student->toArray();
            $student->delete();
            $this->logAudit('delete', $student, $oldValues, null);
        }

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' students deleted successfully.'
        ]);
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('student_ids', []);
        
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No students selected.'], 400);
        }

        $students = Student::withTrashed()->whereIn('id', $ids)->get();

        foreach ($students as $student) {
            $oldValues = $student->toArray();
            foreach ($student->documents as $document) {
                Storage::delete($document->file_path);
                $document->delete();
            }
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $student->forceDelete();
            $this->logAudit('force_delete', $student, $oldValues, null);
        }

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' students permanently deleted.'
        ]);
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

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted all {$count} students."
        ]);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $ids = $request->input('student_ids', []);
        $status = $request->input('status');

        if (empty($ids) || !$status) {
            return response()->json(['success' => false, 'message' => 'No students selected or status not specified.'], 400);
        }

        $students = Student::whereIn('id', $ids)->get();
        foreach ($students as $student) {
            $oldValues = $student->toArray();
            $student->update(['status' => $status]);
            $this->logAudit('update', $student, $oldValues, ['status' => $status]);
        }

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' students updated successfully.'
        ]);
    }

    public function export(Request $request)
    {
        $query = Student::query();

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
                    $student->date_of_birth ? Carbon::parse($student->date_of_birth)->format('Y-m-d') : '',
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

        $document = $student->documents()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'document_type' => $request->type,
            'uploaded_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully.',
            'data' => $document
        ], 201);
    }

    public function downloadDocument(StudentDocument $document)
    {
        return Storage::download($document->file_path, $document->file_name);
    }

    public function deleteDocument(StudentDocument $document)
    {
        $oldValues = $document->toArray();
        $student = $document->student;

        Storage::delete($document->file_path);
        $document->delete();

        $this->logAudit('delete_document', $student, $oldValues, null);

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully.'
        ]);
    }

    private function logAudit($action, $model, $oldValues = null, $newValues = null)
    {
        AuditLog::create([
            'user_id' => Auth::id() ?? 1, // Fallback if no user
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
