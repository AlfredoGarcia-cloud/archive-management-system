<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Share
{
    public function shareFolder(int $folderId, int $userId, int $sharedBy, bool $canRead, bool $canCreate, bool $canUpdate, bool $canDelete): void
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $stmt = $pdo->prepare('INSERT INTO folder_shares (folder_id, user_id, can_read, can_create, can_update, can_delete, shared_by) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE can_read = VALUES(can_read), can_create = VALUES(can_create), can_update = VALUES(can_update), can_delete = VALUES(can_delete), shared_by = VALUES(shared_by)');
        $stmt->execute([$folderId, $userId, $canRead ? 1 : 0, $canCreate ? 1 : 0, $canUpdate ? 1 : 0, $canDelete ? 1 : 0, $sharedBy]);
    }

    public function shareArchive(int $archiveId, int $userId, int $sharedBy, bool $canRead, bool $canUpdate, bool $canDelete): void
    {
        global $config;
        $pdo = Database::connect($config['db']);

        $stmt = $pdo->prepare('INSERT INTO archive_shares (archive_id, user_id, can_read, can_update, can_delete, shared_by) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE can_read = VALUES(can_read), can_update = VALUES(can_update), can_delete = VALUES(can_delete), shared_by = VALUES(shared_by)');
        $stmt->execute([$archiveId, $userId, $canRead ? 1 : 0, $canUpdate ? 1 : 0, $canDelete ? 1 : 0, $sharedBy]);
    }

    public function folderShares(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $sql = 'SELECT fs.folder_id, f.path AS folder_path, u.name AS target_user, fs.can_read, fs.can_create, fs.can_update, fs.can_delete
                FROM folder_shares fs
                JOIN folders f ON f.id = fs.folder_id
                JOIN users u ON u.id = fs.user_id
                ORDER BY fs.created_at DESC';
        return $pdo->query($sql)->fetchAll();
    }

    public function archiveShares(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $sql = 'SELECT ars.archive_id, a.title AS archive_title, u.name AS target_user, ars.can_read, ars.can_update, ars.can_delete
                FROM archive_shares ars
                JOIN archives a ON a.id = ars.archive_id
                JOIN users u ON u.id = ars.user_id
                ORDER BY ars.created_at DESC';
        return $pdo->query($sql)->fetchAll();
    }
}
