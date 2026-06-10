<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
$request = Illuminate\Http\Request::create('/users', 'GET');
$request->setUserResolver(fn() => $user);
$app->instance('request', $request);
if ($user) {
    auth()->login($user);
}
$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() !== 200) {
    file_put_contents('error_output.html', $response->getContent());
    echo "Error saved to error_output.html\n";
} else {
    echo "Page rendered successfully!\n";
}
$kernel->terminate($request, $response);
