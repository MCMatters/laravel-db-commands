<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use McMatters\LaravelDbCommands\Console\Commands\Traits\MigrateTrait;
use McMatters\LaravelDbCommands\Extensions\Database\Migrator;
use RuntimeException;

/**
 * Class MigrateSingle
 *
 * @package McMatters\LaravelDbCommands\Console\Commands
 */
class MigrateSingle extends MigrateCommand
{
    use MigrateTrait;

    /**
     * @var string
     */
    protected $signature = 'migrate:single
        {--file= : The file of migration to be executed.}
        {--class= : The class name of migration.}
        {--database= : The database connection to use.}
        {--force : Force the operation to run when in production.}
        {--pretend : Dump the SQL queries that would be run.}';

    /**
     * @var string
     */
    protected $description = 'Run the single database migration';

    /**
     * MigrateSingle constructor.
     *
     * @param Migrator $migrator
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);
    }

    /**
     * Support for =< 5.4 versions.
     *
     * @return void
     * @throws FileNotFoundException
     * @throws RuntimeException
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * @return void
     * @throws FileNotFoundException
     * @throws RuntimeException
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->checkRequirements();
        $this->prepareDatabase();

        $file = $this->getMigrationFile();

        $this->migrator->run($file, ['pretend' => $this->option('pretend')]);

        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }
    }
}
