<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class ActivityLog
{
    public function latest(int $limit = 100): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $stmt = $pdo->prepare('SELECT al.id, u.name AS user_name, al.action, al.entity_type, al.entity_id, al.description, al.ip_address, al.created_at FROM activity_logs al JOIN users u ON u.id = al.user_id ORDER BY al.created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
