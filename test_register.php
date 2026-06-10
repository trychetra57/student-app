<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$email = 'testx2_' . time() . '@example.com';
$req = Illuminate\Http\Request::create('/register', 'POST', ['name'=>'Test','email'=>$email,'password'=>'password','password_confirmation'=>'password','role'=>'staff']);
$req->setLaravelSession($app['session']->driver());
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
