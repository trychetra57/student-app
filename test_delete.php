<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$userToDelete = App\Models\User::where('email', '!=', 'chhitry@test.com')->where('id', '!=', 8)->first(); // Not the logged-in admin, not a superadmin if possible
if (!$userToDelete) {
    echo "No user to delete.\n";
    exit;
}

$req = Illuminate\Http\Request::create('/users/' . $userToDelete->id, 'DELETE');
$ctrl = new App\Http\Controllers\UserController();
$admin = App\Models\User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
}
try {
    $response = $ctrl->destroy($userToDelete);
    echo "Delete success! Response: " . get_class($response) . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
} catch (\Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
