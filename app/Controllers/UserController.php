<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;
use App\Services\ActivityLogger;

final class UserController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::can('user.manage')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $users = (new User())->all();
        $this->render('users/index', ['title' => 'Manajemen User', 'users' => $users]);
    }

    public function toggleActive(): void
    {
        Auth::requireLogin();
        if (!Auth::can('user.manage')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        $isActive = (int) ($_POST['is_active'] ?? 0) === 1;

        if ($userId === (int) $_SESSION['user']['id']) {
            $_SESSION['error'] = 'Akun sendiri tidak bisa dinonaktifkan.';
            $this->redirect('/users');
        }

        (new User())->updateActiveStatus($userId, $isActive);
        ActivityLogger::log((int) $_SESSION['user']['id'], 'update', 'user', $userId, $isActive ? 'Aktifkan user' : 'Nonaktifkan user');

        $_SESSION['success'] = 'Status user diperbarui.';
        $this->redirect('/users');
    }
}
