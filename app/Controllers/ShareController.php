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

        $folderId = (int) ($_POST['folder_id'] ?? 0);
        $userId = (int) ($_POST['user_id'] ?? 0);
        if ($folderId < 1 || $userId < 1) {
            $_SESSION['error'] = 'Folder dan user wajib dipilih.';
            $this->redirect('/shares');
        }

        (new Share())->shareFolder(
            $folderId,
            $userId,
            (int) $_SESSION['user']['id'],
            isset($_POST['can_read']),
            isset($_POST['can_create']),
            isset($_POST['can_update']),
            isset($_POST['can_delete'])
        );

        ActivityLogger::log((int) $_SESSION['user']['id'], 'update', 'folder_share', $folderId, 'Update share folder');
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

        $archiveId = (int) ($_POST['archive_id'] ?? 0);
        $userId = (int) ($_POST['user_id'] ?? 0);
        if ($archiveId < 1 || $userId < 1) {
            $_SESSION['error'] = 'Arsip dan user wajib dipilih.';
            $this->redirect('/shares');
        }

        (new Share())->shareArchive(
            $archiveId,
            $userId,
            (int) $_SESSION['user']['id'],
            isset($_POST['can_read']),
            isset($_POST['can_update']),
            isset($_POST['can_delete'])
        );

        ActivityLogger::log((int) $_SESSION['user']['id'], 'update', 'archive_share', $archiveId, 'Update share arsip');
        $_SESSION['success'] = 'Share arsip berhasil disimpan.';
        $this->redirect('/shares');
    }
}
