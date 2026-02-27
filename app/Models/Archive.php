<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Archive
{
    public function all(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $sql = 'SELECT a.id, a.title, a.summary, a.file_name, a.file_path, c.name AS category_name, f.path AS folder_path, a.created_at
                FROM archives a
                JOIN categories c ON c.id = a.category_id
                JOIN folders f ON f.id = a.folder_id
                ORDER BY a.created_at DESC';
        return $pdo->query($sql)->fetchAll();
    }

    public function allBySharedUser(int $userId): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $sql = 'SELECT a.id, a.title, a.summary, a.file_name, a.file_path, c.name AS category_name, f.path AS folder_path, a.created_at
                FROM archives a
                JOIN categories c ON c.id = a.category_id
                JOIN folders f ON f.id = a.folder_id
                JOIN archive_shares s ON s.archive_id = a.id
                WHERE s.user_id = ? AND s.can_read = 1
                ORDER BY a.created_at DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function idsAndTitles(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        return $pdo->query('SELECT id, title FROM archives ORDER BY created_at DESC')->fetchAll();
    }
}
