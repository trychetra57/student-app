<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::first();
if (!$user) {
    die("No user found");
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/students', 'GET', ['search' => 'test']);
$request->setUserResolver(function () use ($user) {
    return $user;
});

// Since the auth middleware checks the session or guard, it might be easier to use actingAs if it was a test,
// but for Http\Kernel, we can login manually:
auth()->login($user);

$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() >= 400) {
    if (method_exists($response, 'exception') && $response->exception) {
        echo "Exception: " . $response->exception->getMessage() . "\n";
        echo $response->exception->getTraceAsString();
    } else {
        echo substr($response->getContent(), 0, 1000);
    }
} else {
    echo "SUCCESS\n";
}
$kernel->terminate($request, $response);
