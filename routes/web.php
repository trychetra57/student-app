<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('home');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::delete('/students/{id}/force', [StudentController::class, 'forceDelete'])->name('students.force-delete');

    // Bulk actions
    Route::delete('/students/bulk/delete', [StudentController::class, 'bulkDelete'])->name('students.bulk.delete');
    Route::delete('/students/bulk/force-delete', [StudentController::class, 'bulkForceDelete'])->name('students.bulk.force-delete');
    Route::patch('/students/bulk/status', [StudentController::class, 'bulkUpdateStatus'])->name('students.bulk.status');
    Route::delete('/students/delete-all', [StudentController::class, 'deleteAll'])->name('students.delete-all');

    // Export route moved above dynamic routes
    // Document management
    Route::post('/students/{student}/documents', [StudentController::class, 'uploadDocument'])->name('students.documents.upload');
    Route::get('/documents/{document}/download', [StudentController::class, 'downloadDocument'])->name('documents.download');
    Route::delete('/documents/{document}', [StudentController::class, 'deleteDocument'])->name('documents.delete');

    // Audit logs
    Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');

    // Database backups
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup', [BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/{filename}/download', [BackupController::class, 'download'])->name('backup.download');
    Route::delete('/backup/{filename}', [BackupController::class, 'delete'])->name('backup.delete');
});

// API Routes (JSON responses)
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/students', function () {
        return response()->json([
            'success' => true,
            'data' => \App\Models\Student::with('documents')->get()->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'phone' => $student->phone,
                    'grade' => $student->grade,
                    'status' => $student->status,
                    'documents_count' => $student->documents->count(),
                    'created_at' => $student->created_at,
                ];
            }),
        ]);
    })->name('api.students.index');

    Route::get('/students/{student}', function (\App\Models\Student $student) {
        return response()->json([
            'success' => true,
            'data' => $student->load('documents'),
        ]);
    })->name('api.students.show');

    Route::get('/dashboard/stats', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'total_students' => \App\Models\Student::count(),
                'active_students' => \App\Models\Student::where('status', 'active')->count(),
                'inactive_students' => \App\Models\Student::where('status', 'inactive')->count(),
                'graduated_students' => \App\Models\Student::where('status', 'graduated')->count(),
                'new_this_month' => \App\Models\Student::whereMonth('created_at', now()->month)
                                          ->whereYear('created_at', now()->year)
                                          ->count(),
            ],
        ]);
    })->name('api.dashboard.stats');
});

// API Documentation
Route::middleware('auth')->get('/api/docs', function () {
    return view('api.docs');
})->name('api.docs');
