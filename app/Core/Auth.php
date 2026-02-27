<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\Permission;

final class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function can(string $permissionKey): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        return (new Permission())->roleHasPermission((int) $user['role_id'], $permissionKey);
    }

    public static function canAccessFolder(int $folderId, string $action): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        $permission = new Permission();
        return $permission->roleCanAccessFolder((int) $user['role_id'], $folderId, $action)
            || $permission->userCanAccessSharedFolder((int) $user['id'], $folderId, $action);
    }

    public static function canAccessArchive(int $archiveId, string $action): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        return $permission->userCanAccessSharedArchive((int) $user['id'], $archiveId, $action)
        || $permission->roleCanAccessArchive((int) $user['role_id'], $archiveId, $action);
    }
}
