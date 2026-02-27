<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Archive;
use App\Models\Folder;
use App\Models\Share;
use App\Models\User;
use App\Services\ActivityLogger;

final class ShareController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::can('share.manage')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $me = (int) $_SESSION['user']['id'];
        $this->render('shares/index', [
            'title' => 'Share File / Folder',
            'users' => (new User())->activeUsersExcluding($me),
            'folders' => (new Folder())->all(),
            'archives' => (new Archive())->idsAndTitles(),
            'folderShares' => (new Share())->folderShares(),
            'archiveShares' => (new Share())->archiveShares(),
        ]);
    }

    public function shareFolder(): void
    {
        Auth::requireLogin();
        if (!Auth::can('share.manage')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        (new Share())->shareFolder(
            (int) ($_POST['folder_id'] ?? 0),
            (int) ($_POST['user_id'] ?? 0),
            (int) $_SESSION['user']['id'],
            isset($_POST['can_read']),
            isset($_POST['can_create']),
            isset($_POST['can_update']),
            isset($_POST['can_delete'])
        );

        ActivityLogger::log((int) $_SESSION['user']['id'], 'update', 'folder_share', (int) ($_POST['folder_id'] ?? 0), 'Update share folder');
        $_SESSION['success'] = 'Share folder berhasil disimpan.';
        $this->redirect('/shares');
    }

    public function shareArchive(): void
    {
        Auth::requireLogin();
        if (!Auth::can('share.manage')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        (new Share())->shareArchive(
            (int) ($_POST['archive_id'] ?? 0),
            (int) ($_POST['user_id'] ?? 0),
            (int) $_SESSION['user']['id'],
            isset($_POST['can_read']),
            isset($_POST['can_update']),
            isset($_POST['can_delete'])
        );

        ActivityLogger::log((int) $_SESSION['user']['id'], 'update', 'archive_share', (int) ($_POST['archive_id'] ?? 0), 'Update share arsip');
        $_SESSION['success'] = 'Share arsip berhasil disimpan.';
        $this->redirect('/shares');
    }
}
