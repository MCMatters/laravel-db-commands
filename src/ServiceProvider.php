<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use McMatters\LaravelDbCommands\Console\Commands\DropTables;
use McMatters\LaravelDbCommands\Console\Commands\MigrateSingle;
use McMatters\LaravelDbCommands\Extenders\Database\Migrator;

/**
 * Class ServiceProvider
 *
 * @package McMatters\LaravelDbCommands
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
            return new MigrateSingle(new Migrator($app['migration.repository']));
        });

        $this->commands([
            'command.db.drop-tables',
            'command.migrate.single',
        ]);
    }
}
