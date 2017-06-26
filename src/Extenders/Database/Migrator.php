<?php

declare(strict_types = 1);

namespace McMatters\DbCommands\Extenders\Database;

use Illuminate\Database\Migrations\Migrator as BaseMigrator;

/**
 * Class Migrator
 *
 * @package McMatters\DbCommands\Extenders\Database
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
