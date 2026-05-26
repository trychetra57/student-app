<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$urls = [
    '/students?search=test',
    '/teachers?search=test',
    '/classes?search=test',
    '/users?search=test',
];

// Authenticate a user manually
$user = \App\Models\User::first();
if ($user) {
    auth()->login($user);
}

foreach ($urls as $url) {
    echo "Testing $url...\n";
    $request = Illuminate\Http\Request::create($url, 'GET');
    try {
        $response = $kernel->handle($request);
        if ($response->getStatusCode() >= 400) {
            echo "HTTP " . $response->getStatusCode() . " Error!\n";
            if (isset($response->exception)) {
                echo "Exception: " . $response->exception->getMessage() . "\n";
                echo $response->exception->getTraceAsString() . "\n";
            } else {
                echo "Content: " . strip_tags($response->getContent()) . "\n";
            }
        } else {
            echo "Success: " . $response->getStatusCode() . "\n";
        }
    } catch (\Throwable $e) {
        echo "Exception Caught: " . $e->getMessage() . "\n";
    }
    echo "---------------------------\n";
}
