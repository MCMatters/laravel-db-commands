<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands\Extenders\Database;

use Illuminate\Database\Migrations\Migrator as BaseMigrator;

/**
 * Class Migrator
 *
 * @package McMatters\LaravelDbCommands\Extenders\Database
 */
class Migrator extends BaseMigrator
{
    /**
     * @param string $file
     *
     * @return array
     */
    public function getMigrationFiles($file): array
    {
        return [$file];
    }
}
