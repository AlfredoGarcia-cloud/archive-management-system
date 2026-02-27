<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\LetterNumber;

final class LetterNumberController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::can('letter_number.read')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $letterNumbers = (new LetterNumber())->all();
        $this->render('letters/index', ['title' => 'Penomoran Surat', 'letterNumbers' => $letterNumbers]);
    }
}
