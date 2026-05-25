<?php
$user = App\Models\User::first();
auth()->login($user);
$response = app()->handle(Illuminate\Http\Request::create('/users', 'GET'));
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() !== 200) {
    file_put_contents('error_output.html', $response->getContent());
    echo "Error saved to error_output.html\n";
} else {
    echo "Page rendered successfully!\n";
}
