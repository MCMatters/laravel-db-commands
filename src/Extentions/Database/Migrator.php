<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands\Extentions\Database;

use Illuminate\Database\Migrations\Migrator as BaseMigrator;
use const PATHINFO_FILENAME;
use function pathinfo;

/**
 * Class Migrator
 *
 * @package McMatters\LaravelDbCommands\Extentions\Database
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
        return [pathinfo($file, PATHINFO_FILENAME) => $file];
    }
}
