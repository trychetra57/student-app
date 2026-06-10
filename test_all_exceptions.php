<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$urls = [
    '/students?search=test',
    '/teachers?search=test',
    '/classes?search=test',
    '/users?search=test',
    '/attendance',
    '/grades',
];

$student = \App\Models\Student::first();
if ($student) {
    $urls[] = "/students/{$student->id}/transcript";
}

// Authenticate a user manually
$user = \App\Models\User::where('role', 'super_admin')->first();

foreach ($urls as $url) {
    echo "Testing $url...\n";
    $request = Illuminate\Http\Request::create($url, 'GET');
    $request->setUserResolver(fn() => $user);
    if ($user) {
        auth()->login($user);
    }
    try {
        $response = $kernel->handle($request);
        if ($response->isRedirect()) {
            echo "Redirect: " . $response->headers->get('Location') . "\n";
        } elseif ($response->getStatusCode() >= 400) {
            echo "HTTP " . $response->getStatusCode() . " Error!\n";
            if (isset($response->exception) && $response->exception) {
                echo "Exception: " . $response->exception->getMessage() . "\n";
            } else {
                echo "Content: " . substr(strip_tags($response->getContent()), 0, 500) . "\n";
            }
        } else {
            echo "Success: " . $response->getStatusCode() . "\n";
        }
    } catch (\Throwable $e) {
        echo "Caught: " . $e->getMessage() . "\n";
    }
    echo "---------------------------\n";
}
