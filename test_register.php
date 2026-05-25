<?php
$req = Illuminate\Http\Request::create('/register', 'POST', ['name'=>'Test','email'=>'testx2@example.com','password'=>'password','password_confirmation'=>'password','role'=>'staff']);
$ctrl = new App\Http\Controllers\Auth\WebAuthController();
try {
    $response = $ctrl->register($req);
    echo "Register success!\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
} catch (\Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
