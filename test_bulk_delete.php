<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;

// Create a mock request
$user = User::first();
auth()->login($user);

$student = Student::first();
if (!$student) {
    echo "No students found to delete.\n";
    exit;
}

$request = new Request();
$request->merge(['student_ids' => [$student->id]]);

$controller = new StudentController();
try {
    $response = $controller->bulkDelete($request);
    echo "Bulk delete successful. Redirected to: " . $response->getTargetUrl() . "\n";
    
    // Verify deletion
    $check = Student::find($student->id);
    if (!$check) {
        echo "Student soft-deleted successfully.\n";
    } else {
        echo "Student still exists in DB!\n";
    }
} catch (\Exception $e) {
    echo "Error during bulk delete: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
