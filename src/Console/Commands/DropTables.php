<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use function reset;

/**
 * Class DropTables
 *
 * @package McMatters\LaravelDbCommands\Console\Commands
 */
class DropTables extends Command
{
    use ConfirmableTrait;

    /**
     * @var string
     */
    protected $signature = 'db:drop-tables {--force : Enforce an action}';

    /**
     * @var string
     */
    protected $description = 'Drops all tables in the default configuration.';

    /**
     * Support for =< 5.4 versions.
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * @return void
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        Schema::disableForeignKeyConstraints();

        foreach (DB::select('SHOW TABLES') as $table) {
            Schema::dropIfExists(reset($table));
        }

        Schema::enableForeignKeyConstraints();
    }
}
