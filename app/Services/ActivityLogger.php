<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

final class ActivityLogger
{
    public static function log(int $userId, string $action, string $entityType, int $entityId, string $description): void
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $stmt = $pdo->prepare('INSERT INTO activity_logs (user_id, action, entity_type, entity_id, description, ip_address) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $userId,
            strtoupper($action),
            $entityType,
            $entityId,
            $description,
            $_SERVER['REMOTE_ADDR'] ?? 'CLI',
        ]);
    }
}
