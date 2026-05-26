<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
if (!$user) {
    die("No user found\n");
}

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// test API
$request = Illuminate\Http\Request::create('/api/students', 'GET', ['search' => 'test']);
$request->headers->set('Accept', 'application/json');
$request->setUserResolver(fn() => $user);

\Laravel\Sanctum\Sanctum::actingAs($user, ['*']);

$response = $httpKernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() >= 400) {
    if (isset($response->exception) && $response->exception) {
        echo "Exception: " . $response->exception->getMessage() . "\n";
    } else {
        echo substr($response->getContent(), 0, 500) . "\n";
    }
} else {
    echo "SUCCESS, got " . strlen($response->getContent()) . " bytes.\n";
    echo substr($response->getContent(), 0, 500) . "\n";
}
$httpKernel->terminate($request, $response);
