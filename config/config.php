<?php

declare(strict_types=1);

return [
    'app' => [
        'name' => 'Archive Management System',
        'base_url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
        'timezone' => 'Asia/Jakarta',
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
        'database' => $_ENV['DB_DATABASE'] ?? 'archive_management',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        'session_name' => 'archive_session',
    ],
];
