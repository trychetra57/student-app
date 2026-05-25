<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\WebStudentController;
use App\Http\Controllers\WebAuditController;
use App\Http\Controllers\WebBackupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebTeacherController;
use App\Http\Controllers\WebSchoolClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// ─── Auth Routes ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [WebAuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');
    
    if (app()->environment('local')) {
        Route::post('/quick-login', function(Illuminate\Http\Request $request) {
            $role = $request->input('role');
            $user = \App\Models\User::where('role', $role)->first();
            if ($user) {
                auth()->login($user);
                $request->session()->regenerate();
                return redirect()->route('dashboard')->with('success', "Logged in quickly as {$role}.");
            }
            return back()->with('error', "No user found with role: {$role}. Please register one first.");
        })->name('quick-login');
    }
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
    Route::get('/backup/{filename}/download', [WebBackupController::class, 'download'])->name('backup.download');
    Route::delete('/backup/{filename}', [WebBackupController::class, 'destroy'])->name('backup.destroy');

    // API Docs
    Route::get('/api-docs', fn() => view('api.docs'))->name('api.docs');

    // User Management (admin only — enforced in controller)
    Route::get('/users',              [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit',  [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',       [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',    [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');

    // Students — export & bulk BEFORE resource
    Route::get('/students/export',               [WebStudentController::class, 'export'])->name('students.export');
    Route::delete('/students/delete-all',        [WebStudentController::class, 'deleteAll'])->name('students.delete-all');
    Route::delete('/students/bulk-delete',       [WebStudentController::class, 'bulkDelete'])->name('students.bulk.delete');
    Route::delete('/students/bulk-force-delete', [WebStudentController::class, 'bulkForceDelete'])->name('students.bulk.force-delete');
    Route::patch('/students/bulk-status',        [WebStudentController::class, 'bulkUpdateStatus'])->name('students.bulk.status');

    // Document routes
    Route::post('/students/{student}/documents',  [WebStudentController::class, 'uploadDocument'])->name('students.documents.upload');
    Route::get('/documents/{document}/download',  [WebStudentController::class, 'downloadDocument'])->name('documents.download');
    Route::delete('/documents/{document}',        [WebStudentController::class, 'deleteDocument'])->name('documents.delete');

    // Standard student CRUD
    Route::resource('students', WebStudentController::class);

    // Teachers CRUD
    Route::resource('teachers', WebTeacherController::class);

    // Classes CRUD
    Route::resource('classes', WebSchoolClassController::class)->parameters(['classes' => 'class']);
});
