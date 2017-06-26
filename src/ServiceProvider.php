<?php

declare(strict_types = 1);

namespace McMatters\DbCommands;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use McMatters\DbCommands\Console\Commands\DropTables;
use McMatters\DbCommands\Console\Commands\MigrateSingle;
use McMatters\DbCommands\Extenders\Database\Migrator;

/**
 * Class ServiceProvider
 *
 * @package McMatters\DbCommands
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.db.drop-tables', function () {
            return new DropTables();
        });
        $this->app->singleton('command.migrate.single', function ($app) {
            return new MigrateSingle(
                new Migrator($app['migration.repository'], $app['db'], $app['files'])
            );
        });

        $this->commands([
            'command.db.drop-tables',
            'command.migrate.single',
        ]);
    }
}
