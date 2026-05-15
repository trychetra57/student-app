<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\WebStudentController;
use App\Http\Controllers\WebAuditController;
use App\Http\Controllers\WebBackupController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// ─── Auth Routes (Guest only) ─────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [WebAuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');
});

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [WebStudentController::class, 'dashboard'])->name('dashboard');

    // Audit Logs
    Route::get('/audit', [WebAuditController::class, 'index'])->name('audit.index');

    // Backup
    Route::get('/backup',  [WebBackupController::class, 'index'])->name('backup.index');
    Route::post('/backup', [WebBackupController::class, 'create'])->name('backup.create');

    // API Docs
    Route::get('/api-docs', function () {
        return view('api.docs');
    })->name('api.docs');

    // Students — export & bulk actions BEFORE resource (avoid route conflicts)
    Route::get('/students/export',              [WebStudentController::class, 'export'])->name('students.export');
    Route::delete('/students/delete-all',       [WebStudentController::class, 'deleteAll'])->name('students.delete-all');
    Route::delete('/students/bulk-delete',      [WebStudentController::class, 'bulkDelete'])->name('students.bulk.delete');
    Route::delete('/students/bulk-force-delete',[WebStudentController::class, 'bulkForceDelete'])->name('students.bulk.force-delete');
    Route::patch('/students/bulk-status',       [WebStudentController::class, 'bulkUpdateStatus'])->name('students.bulk.status');

    // Document routes
    Route::post('/students/{student}/documents',        [WebStudentController::class, 'uploadDocument'])->name('students.documents.upload');
    Route::get('/documents/{document}/download',        [WebStudentController::class, 'downloadDocument'])->name('documents.download');
    Route::delete('/documents/{document}',              [WebStudentController::class, 'deleteDocument'])->name('documents.delete');

    // Standard student CRUD
    Route::resource('students', WebStudentController::class);
});
