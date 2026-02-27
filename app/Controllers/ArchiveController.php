<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Archive;

final class ArchiveController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $model = new Archive();
        if (Auth::can('archive.read')) {
            $archives = $model->all();
        } else {
            $archives = $model->allBySharedUser((int) $_SESSION['user']['id']);
            if (count($archives) === 0) {
                http_response_code(403);
                echo 'Akses ditolak.';
                return;
            }
        }

        if (!Auth::can('archive.read')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $archives = (new Archive())->all();
        $this->render('archives/index', ['title' => 'Arsip', 'archives' => $archives]);
    }
}
