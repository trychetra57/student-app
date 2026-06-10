<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::where('id', '!=', 8)->get();
foreach ($users as $user) {
    try {
        $user->delete();
        echo "Deleted user {$user->id}\n";
    } catch (\Exception $e) {
        echo "Error deleting user {$user->id}: " . $e->getMessage() . "\n";
    } catch (\Error $e) {
        echo "Fatal Error deleting user {$user->id}: " . $e->getMessage() . "\n";
    }
}
