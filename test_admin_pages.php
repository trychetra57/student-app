<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$urls = [
    '/dashboard',
    '/admin/sliders',
    '/admin/about-us',
    '/admin/courses',
    '/admin/news',
    '/admin/galleries',
    '/admin/footer-pages',
    '/audit',
    '/backup',
    '/api-docs',
    '/users',
    '/students',
    '/teachers',
    '/classes',
];

$user = \App\Models\User::where('role', 'super_admin')->first();
if (!$user) {
    echo "No super admin found!\n";
    exit(1);
}

foreach ($urls as $url) {
    echo "Testing $url...\n";
    $request = Illuminate\Http\Request::create($url, 'GET');
    $request->setUserResolver(fn() => $user);
    auth()->login($user);
    try {
        $response = $kernel->handle($request);
        if ($response->getStatusCode() >= 400) {
            echo "HTTP " . $response->getStatusCode() . " Error!\n";
            if (isset($response->exception) && $response->exception) {
                echo "Exception: " . $response->exception->getMessage() . "\n";
                echo "Trace: " . substr($response->exception->getTraceAsString(), 0, 1000) . "\n";
            } else {
                echo "Content: " . substr(strip_tags($response->getContent()), 0, 500) . "\n";
            }
        } else {
            echo "Success: " . $response->getStatusCode() . "\n";
        }
    } catch (\Throwable $e) {
        echo "Caught: " . $e->getMessage() . "\n";
        echo substr($e->getTraceAsString(), 0, 1000) . "\n";
    }
    echo "---------------------------\n";
}
