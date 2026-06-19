<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all(['id','name','email','role','is_active','password']);
foreach ($users as $u) {
    $testPasswords = ['password', '123456', 'admin123', 'secret', 'password123'];
    $matched = null;
    foreach ($testPasswords as $pass) {
        if (\Illuminate\Support\Facades\Hash::check($pass, $u->password)) {
            $matched = $pass;
            break;
        }
    }
    echo "email={$u->email} | role={$u->role} | password=" . ($matched ?? '(unknown)') . "\n";
}
