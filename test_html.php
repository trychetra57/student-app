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
$request = Illuminate\Http\Request::create('/students', 'GET', ['search' => 'a']);
$request->setUserResolver(fn() => $user);
auth()->login($user);

$response = $httpKernel->handle($request);
if ($response->getStatusCode() !== 200) {
    echo "Status: " . $response->getStatusCode() . "\n";
    if (isset($response->exception) && $response->exception) {
        echo "Exception: " . $response->exception->getMessage() . "\n";
    }
} else {
    $content = $response->getContent();
    if (stripos($content, 'error') !== false) {
        echo "The page contains the word 'error'.\n";
        // print the lines with error
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            if (stripos($line, 'error') !== false) {
                echo trim($line) . "\n";
            }
        }
    } else {
        echo "No 'error' string found in the page.\n";
    }
}
$httpKernel->terminate($request, $response);
