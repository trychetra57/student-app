<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$urls = [
    '/',
    '/programs',
    '/tuition',
    '/services',
    '/events',
    '/placement-test',
    '/pages/privacy-policy',
    '/pages/terms-of-service',
];

foreach ($urls as $url) {
    echo "Testing $url...\n";
    $request = Illuminate\Http\Request::create($url, 'GET');
    try {
        $response = $kernel->handle($request);
        if ($response->getStatusCode() >= 400) {
            echo "HTTP " . $response->getStatusCode() . " Error!\n";
            if (isset($response->exception) && $response->exception) {
                echo "Exception: " . $response->exception->getMessage() . "\n";
                echo "Trace: " . $response->exception->getTraceAsString() . "\n";
            } else {
                echo "Content: " . substr(strip_tags($response->getContent()), 0, 500) . "\n";
            }
        } else {
            echo "Success: " . $response->getStatusCode() . "\n";
        }
    } catch (\Throwable $e) {
        echo "Caught: " . $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
    }
    echo "---------------------------\n";
}
