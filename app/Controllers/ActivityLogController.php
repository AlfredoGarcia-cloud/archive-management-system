<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\ActivityLog;

final class ActivityLogController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::can('activity_log.read')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $logs = (new ActivityLog())->latest(200);
        $this->render('logs/index', ['title' => 'Log Aktivitas', 'logs' => $logs]);
    }
}
