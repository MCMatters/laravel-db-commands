<?php

declare(strict_types=1);

namespace McMatters\LaravelDbCommands\Extensions\Database;

use Illuminate\Database\Migrations\Migrator as BaseMigrator;

use function pathinfo;

use const PATHINFO_FILENAME;

/**
 * Class Migrator
 *
 * @package McMatters\LaravelDbCommands\Extensions\Database
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
