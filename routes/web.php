<?php

declare(strict_types=1);

use App\Controllers\ActivityLogController;
use App\Controllers\ArchiveController;
use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;
use App\Controllers\FolderController;
use App\Controllers\LetterNumberController;
use App\Controllers\ShareController;
use App\Controllers\UserController;

$router->get('/', [AuthController::class, 'loginForm']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/folders', [FolderController::class, 'index']);
$router->post('/folders', [FolderController::class, 'store']);
$router->get('/archives', [ArchiveController::class, 'index']);
$router->get('/letter-numbers', [LetterNumberController::class, 'index']);
$router->get('/categories', [CategoryController::class, 'index']);
$router->get('/activity-logs', [ActivityLogController::class, 'index']);
$router->get('/users', [UserController::class, 'index']);
$router->post('/users/toggle-active', [UserController::class, 'toggleActive']);
$router->get('/shares', [ShareController::class, 'index']);
$router->post('/shares/folders', [ShareController::class, 'shareFolder']);
$router->post('/shares/archives', [ShareController::class, 'shareArchive']);
