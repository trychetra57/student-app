<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$q = \App\Models\SchoolClass::query()->with('teacher');
$s = 'test';
$q->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('room_number', 'like', "%$s%"));
echo $q->get()->count() . " success\n";
