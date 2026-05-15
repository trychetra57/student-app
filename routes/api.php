<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BackupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard/stats', [StudentController::class, 'dashboard']);
    
    // Students CRUD
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/export', [StudentController::class, 'export']);
    Route::get('/students/{student}', [StudentController::class, 'show']);
    Route::put('/students/{student}', [StudentController::class, 'update']);
    Route::delete('/students/{student}', [StudentController::class, 'destroy']);
    Route::delete('/students/{id}/force', [StudentController::class, 'forceDelete']);

    // Bulk actions
    Route::post('/students/bulk-delete', [StudentController::class, 'bulkDelete']);
    Route::post('/students/bulk-status', [StudentController::class, 'bulkUpdateStatus']);
    Route::delete('/students/delete-all', [StudentController::class, 'deleteAll']);

    // Document management
    Route::post('/students/{student}/documents', [StudentController::class, 'uploadDocument']);
    Route::get('/documents/{document}/download', [StudentController::class, 'downloadDocument']);
    Route::delete('/documents/{document}', [StudentController::class, 'deleteDocument']);

    // Audit logs
    Route::get('/audit', [AuditController::class, 'index']);
});
