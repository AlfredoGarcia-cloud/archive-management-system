<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Category
{
    public function all(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        return $pdo->query('SELECT id, code, name, description FROM categories ORDER BY name ASC')->fetchAll();
    }
}
