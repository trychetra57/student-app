<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('role', 'super_admin')->first();
if (!$user) {
    die("No user found\n");
}

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$endpoints = ['/students', '/users', '/teachers', '/classes'];

foreach ($endpoints as $ep) {
    $request = Illuminate\Http\Request::create($ep, 'GET', ['search' => 'test']);
    $request->setUserResolver(fn() => $user);
    auth()->login($user);

    $response = $httpKernel->handle($request);
    echo "Endpoint: $ep\n";
    echo "Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() >= 400) {
        if (isset($response->exception) && $response->exception) {
            echo "Exception: " . $response->exception->getMessage() . "\n";
        } else {
            echo substr($response->getContent(), 0, 500) . "\n";
        }
    } else {
        echo "SUCCESS, got " . strlen($response->getContent()) . " bytes.\n";
    }
    $httpKernel->terminate($request, $response);
    echo "---------------------------\n";
}
