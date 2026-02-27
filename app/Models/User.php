<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class User
{
    public function findByEmail(string $email): ?array
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $sql = 'SELECT u.id, u.name, u.email, u.is_active, r.name AS role_name
                FROM users u JOIN roles r ON r.id = u.role_id
                ORDER BY u.created_at DESC';
        return $pdo->query($sql)->fetchAll();
    }

    public function updateActiveStatus(int $userId, bool $isActive): void
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $stmt = $pdo->prepare('UPDATE users SET is_active = ? WHERE id = ?');
        $stmt->execute([$isActive ? 1 : 0, $userId]);
    }

    public function activeUsersExcluding(int $userId): array
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $stmt = $pdo->prepare('SELECT id, name, email FROM users WHERE is_active = 1 AND id <> ? ORDER BY name ASC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
