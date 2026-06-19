<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\WebStudentController;
use App\Http\Controllers\WebAuditController;
use App\Http\Controllers\WebBackupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebTeacherController;
use App\Http\Controllers\WebSchoolClassController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\FrontWebController;
use Illuminate\Support\Facades\Route;

// ─── Public Website Routes ────────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/programs', [PublicController::class, 'programs'])->name('programs');
Route::get('/tuition', [PublicController::class, 'tuition'])->name('tuition');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/placement-test', [PublicController::class, 'placementTest'])->name('placement-test');
Route::post('/placement-test/submit', [PublicController::class, 'submitPlacementTest'])->name('placement-test.submit');
Route::get('/success-hub', [PublicController::class, 'successHub'])->name('success-hub');
Route::post('/contact-submit', [PublicController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/pages/{slug}', [PublicController::class, 'showPage'])->name('public.pages.show');

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
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => ucwords(str_replace('_', ' ', $role)),
                    'email' => $role . '@learn.edu.kh',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => $role,
                    'is_active' => true
                ]);
            }
            auth()->login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', "Logged in quickly as {$role}.");
        })->name('quick-login');
    }
});

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [WebStudentController::class, 'dashboard'])->name('dashboard');

    // Profile page
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');

    // Front Web Management
    // Sliders
    Route::get('/admin/sliders', [FrontWebController::class, 'sliders'])->name('admin.sliders.index');
    Route::post('/admin/sliders', [FrontWebController::class, 'storeSlider'])->name('admin.sliders.store');
    Route::post('/admin/sliders/{slider}', [FrontWebController::class, 'updateSlider'])->name('admin.sliders.update');
    Route::delete('/admin/sliders/{slider}', [FrontWebController::class, 'destroySlider'])->name('admin.sliders.destroy');
    Route::post('/admin/sliders/{slider}/toggle', [FrontWebController::class, 'toggleSliderStatus'])->name('admin.sliders.toggle');
    Route::post('/admin/sliders/reorder', [FrontWebController::class, 'reorderSliders'])->name('admin.sliders.reorder');

    // About Us
    Route::get('/admin/about-us', [FrontWebController::class, 'aboutUs'])->name('admin.about-us.index');
    Route::post('/admin/about-us', [FrontWebController::class, 'updateAboutUs'])->name('admin.about-us.update');

    // Courses
    Route::get('/admin/courses', [FrontWebController::class, 'courses'])->name('admin.courses.index');
    Route::post('/admin/courses', [FrontWebController::class, 'storeCourse'])->name('admin.courses.store');
    Route::put('/admin/courses/{course}', [FrontWebController::class, 'updateCourse'])->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [FrontWebController::class, 'destroyCourse'])->name('admin.courses.destroy');
    Route::post('/admin/courses/{course}/toggle', [FrontWebController::class, 'toggleCourseStatus'])->name('admin.courses.toggle');

    // News
    Route::get('/admin/news', [FrontWebController::class, 'news'])->name('admin.news.index');
    Route::post('/admin/news', [FrontWebController::class, 'storeNews'])->name('admin.news.store');
    Route::post('/admin/news/{news}', [FrontWebController::class, 'updateNews'])->name('admin.news.update');
    Route::delete('/admin/news/{news}', [FrontWebController::class, 'destroyNews'])->name('admin.news.destroy');
    Route::post('/admin/news/{news}/toggle', [FrontWebController::class, 'toggleNewsStatus'])->name('admin.news.toggle');

    // Galleries
    Route::get('/admin/galleries', [FrontWebController::class, 'galleries'])->name('admin.galleries.index');
    Route::post('/admin/galleries', [FrontWebController::class, 'storeGallery'])->name('admin.galleries.store');
    Route::delete('/admin/galleries/{gallery}', [FrontWebController::class, 'destroyGallery'])->name('admin.galleries.destroy');

    // Footer Pages
    Route::get('/admin/footer-pages', [FrontWebController::class, 'footerPages'])->name('admin.footer-pages.index');
    Route::post('/admin/footer-pages', [FrontWebController::class, 'storeFooterPage'])->name('admin.footer-pages.store');
    Route::put('/admin/footer-pages/{page}', [FrontWebController::class, 'updateFooterPage'])->name('admin.footer-pages.update');
    Route::delete('/admin/footer-pages/{page}', [FrontWebController::class, 'destroyFooterPage'])->name('admin.footer-pages.destroy');
    Route::post('/admin/footer-pages/{page}/toggle', [FrontWebController::class, 'toggleFooterPageStatus'])->name('admin.footer-pages.toggle');

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

    // Class Enrollment
    Route::get('/classes/{class}/enroll', [WebSchoolClassController::class, 'showEnrollment'])->name('classes.enroll.show');
    Route::post('/classes/{class}/enroll', [WebSchoolClassController::class, 'enrollStudents'])->name('classes.enroll.store');

    // Attendance Management
    Route::get('/attendance', [\App\Http\Controllers\WebAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/class/{class}', [\App\Http\Controllers\WebAttendanceController::class, 'showSheet'])->name('attendance.sheet');
    Route::post('/attendance/class/{class}', [\App\Http\Controllers\WebAttendanceController::class, 'saveSheet'])->name('attendance.store');

    // Grades & Transcripts
    Route::get('/grades', [\App\Http\Controllers\WebGradeController::class, 'index'])->name('grades.index');
    Route::get('/grades/class/{class}', [\App\Http\Controllers\WebGradeController::class, 'classGrades'])->name('grades.class');
    Route::post('/grades/class/{class}', [\App\Http\Controllers\WebGradeController::class, 'saveGrades'])->name('grades.store');
    Route::get('/students/{student}/transcript', [\App\Http\Controllers\WebGradeController::class, 'studentTranscript'])->name('students.transcript');
});
