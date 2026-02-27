<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Folder
{
    public function all(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        return $pdo->query('SELECT id, name, parent_id, path, created_at FROM folders ORDER BY path ASC')->fetchAll();
    }

    public function create(string $name, ?int $parentId, string $path, int $createdBy): int
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $stmt = $pdo->prepare('INSERT INTO folders (name, parent_id, path, created_by) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $parentId, $path, $createdBy]);
        return (int) $pdo->lastInsertId();
    }
}
