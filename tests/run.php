<?php

declare(strict_types=1);

require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Core/View.php';

use App\Core\Router;
use App\Core\View;

$_SESSION = [];

$passed = 0;
$failed = 0;
$results = [];

$assert = function (bool $condition, string $message) use (&$passed, &$failed, &$results): void {
    if ($condition) {
        $passed++;
        $results[] = "[PASS] {$message}";
        return;
    }

    $failed++;
    $results[] = "[FAIL] {$message}";
};

$router = new Router();
$flag = false;
$router->get('/health', function () use (&$flag): void {
    $flag = true;
});
$router->dispatch('GET', '/health');
$assert($flag === true, 'Router dispatches callable handler for existing GET route');

ob_start();
http_response_code(200);
$router->dispatch('GET', '/unknown');
$output404 = ob_get_clean();
$assert(http_response_code() === 404, 'Router returns HTTP 404 for unknown route');
$assert(str_contains($output404, 'Halaman tidak ditemukan.'), 'Router outputs not found message');

ob_start();
View::render('auth/login', ['title' => 'Login']);
$loginHtml = ob_get_clean();
$assert(!str_contains($loginHtml, 'href="/logout"'), 'Guest login page does not show logout link/nav');
$assert(str_contains($loginHtml, 'Login Sistem Arsip'), 'Login view is rendered correctly');

foreach ($results as $line) {
    echo $line . "\n";
}

echo "\nTotal PASS: {$passed}, FAIL: {$failed}\n";

if ($failed > 0) {
    exit(1);
}
