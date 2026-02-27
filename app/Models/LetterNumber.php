<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class LetterNumber
{
    public function all(): array
    {
        global $config;
        $pdo = Database::connect($config['db']);
        return $pdo->query('SELECT ln.id, ln.sequence_no, lnf.name AS format_name, ln.generated_number, ln.description, ln.created_at FROM letter_numbers ln JOIN letter_number_formats lnf ON lnf.id = ln.format_id ORDER BY ln.created_at DESC')->fetchAll();
    }
}
