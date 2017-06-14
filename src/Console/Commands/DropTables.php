<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class DropTables
 *
 * @package McMatters\LaravelDbCommands\Console\Commands
 */
class DropTables extends Command
{
    /**
     * @var string
     */
    protected $signature = 'db:drop-tables {--force : Enforce an action}';

    /**
     * @var string
     */
    protected $description = 'Drops all tables in the default configuration.';

    /**
     * Run command.
     */
    public function handle()
    {
        if (!$this->isForced() && !$this->isLocalEnvironment()) {
            $this->error(
                'This action can\'t be performed in non-local environment.
                    Please use --force option if you really want to proceed.'
            );
        }

        Schema::disableForeignKeyConstraints();

        foreach (DB::select('SHOW TABLES') as $table) {
            Schema::dropIfExists(reset($table));
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Check force mode.
     *
     * @return bool
     */
    protected function isForced(): bool
    {
        return null !== $this->option('force');
    }

    /**
     * @return bool
     */
    protected function isLocalEnvironment(): bool
    {
        return in_array(config('app.env'), ['production', 'live'], true);
    }
}
