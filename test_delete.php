<?php
$userToDelete = App\Models\User::where('email', '!=', 'chhitry@test.com')->where('id', '!=', 8)->first(); // Not the logged-in admin, not a superadmin if possible
if (!$userToDelete) {
    echo "No user to delete.\n";
    exit;
}

$req = Illuminate\Http\Request::create('/users/' . $userToDelete->id, 'DELETE');
$ctrl = new App\Http\Controllers\UserController();
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
