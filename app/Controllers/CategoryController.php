<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Category;

final class CategoryController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::can('category.read')) {
            http_response_code(403);
            echo 'Akses ditolak.';
            return;
        }

        $categories = (new Category())->all();
        $this->render('categories/index', ['title' => 'Kategori Surat', 'categories' => $categories]);
    }
}
