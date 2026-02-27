<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Permission
{
    public function roleHasPermission(int $roleId, string $permissionKey): bool
    {
        global $config;
        $pdo = Database::connect($config['db']);
        $stmt = $pdo->prepare('SELECT 1 FROM role_permissions rp JOIN permissions p ON p.id = rp.permission_id WHERE rp.role_id = ? AND p.permission_key = ? LIMIT 1');
        $stmt->execute([$roleId, $permissionKey]);
        return (bool) $stmt->fetchColumn();
    }

    public function roleCanAccessFolder(int $roleId, int $folderId, string $action): bool
    {
        $map = ['read' => 'can_read', 'create' => 'can_create', 'update' => 'can_update', 'delete' => 'can_delete'];
        $column = $map[$action] ?? 'can_read';

        global $config;
        $pdo = Database::connect($config['db']);
        $stmt = $pdo->prepare("SELECT {$column} FROM folder_permissions WHERE role_id = ? AND folder_id = ? LIMIT 1");
        $stmt->execute([$roleId, $folderId]);
        return (bool) $stmt->fetchColumn();
    }

    public function userCanAccessSharedFolder(int $userId, int $folderId, string $action): bool
    {
        $map = ['read' => 'can_read', 'create' => 'can_create', 'update' => 'can_update', 'delete' => 'can_delete'];
        $column = $map[$action] ?? 'can_read';

        global $config;
        $pdo = Database::connect($config['db']);
        $stmt = $pdo->prepare("SELECT {$column} FROM folder_shares WHERE user_id = ? AND folder_id = ? LIMIT 1");
        $stmt->execute([$userId, $folderId]);
        return (bool) $stmt->fetchColumn();
    }

    public function userCanAccessSharedArchive(int $userId, int $archiveId, string $action): bool
    {
        $map = ['read' => 'can_read', 'update' => 'can_update', 'delete' => 'can_delete'];
        $column = $map[$action] ?? 'can_read';

        global $config;
        $pdo = Database::connect($config['db']);
        $stmt = $pdo->prepare("SELECT {$column} FROM archive_shares WHERE user_id = ? AND archive_id = ? LIMIT 1");
        $stmt->execute([$userId, $archiveId]);
        return (bool) $stmt->fetchColumn();
    }
}
