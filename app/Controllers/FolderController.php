<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Folder;
use App\Services\ActivityLogger;

final class FolderController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::can('folder.read')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $folders = (new Folder())->all();
        $this->render('folders/index', ['title' => 'Folder', 'folders' => $folders]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        if (!Auth::can('folder.create')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $parentId = !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : null;
        $path = trim($_POST['path'] ?? '');

        $folderId = (new Folder())->create($name, $parentId, $path, (int) $_SESSION['user']['id']);
        ActivityLogger::log((int) $_SESSION['user']['id'], 'create', 'folder', $folderId, 'Membuat folder: ' . $name);

        $_SESSION['success'] = 'Folder berhasil dibuat.';
        $this->redirect('/folders');
    }
}
