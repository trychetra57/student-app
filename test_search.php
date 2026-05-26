<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$s = 'test';
try {
    $q = \App\Models\Student::query();
    $q->where(fn($query) => $query
        ->where('name', 'like', "%$s%")
        ->orWhere('email', 'like', "%$s%")
        ->orWhere('phone', 'like', "%$s%")
        ->orWhere('grade', 'like', "%$s%")
        ->orWhere('address','like',"%$s%")
    );
    echo "SQL: " . $q->toSql() . "\n";
    $q->get();
    echo "SUCCESS\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
