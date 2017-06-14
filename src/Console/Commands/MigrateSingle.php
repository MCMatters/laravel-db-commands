<?php

declare(strict_types = 1);

namespace McMatters\LaravelDbCommands\Console\Commands;

use Illuminate\Database\Console\Migrations\MigrateCommand;
use McMatters\LaravelDbCommands\Extenders\Database\Migrator;

/**
 * Class MigrateSingle
 *
 * @package McMatters\LaravelDbCommands\Console\Commands
 */
class MigrateSingle extends MigrateCommand
{
    /**
     * @var string
     */
    protected $signature = 'migrate:single {file : The file of migration to be executed.}
        {--database= : The database connection to use.}
        {--force : Force the operation to run when in production.}
        {--pretend : Dump the SQL queries that would be run.}';

    /**
     * @var string
     */
    protected $description = 'Run the database migration';

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
     * @return void
     */
    public function fire()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->prepareDatabase();

        $file = $this->getMigrationPath().'/'.$this->argument('file');

        $this->migrator->run($file, ['pretend' => $this->option('pretend')]);

        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }
    }
}
