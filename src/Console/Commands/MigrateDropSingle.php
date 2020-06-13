<?php

declare(strict_types=1);

namespace McMatters\LaravelDbCommands\Console\Commands;

use Illuminate\Console\ConfirmableTrait;
use Illuminate\Database\Console\Migrations\BaseCommand;
use McMatters\LaravelDbCommands\Console\Commands\Traits\MigrateTrait;
use McMatters\LaravelDbCommands\Extensions\Database\Migrator;

use function count, strpos;

use const false;

/**
 * Class MigrateDropSingle
 *
 * @package McMatters\LaravelDbCommands\Console\Commands
 */
class MigrateDropSingle extends BaseCommand
{
    use ConfirmableTrait;
    use MigrateTrait;

    /**
     * @var string
     */
    protected $signature = 'migrate:drop-single
        {--file= : The file of migration to be executed.}
        {--class= : The class name of migration.}
        {--database= : The database connection to use.}
        {--force : Force the operation to run when in production.}
        {--pretend : Dump the SQL queries that would be run.}';

    /**
     * @var string
     */
    protected $description = 'Drop the single database migration';

    /**
     * @var \McMatters\LaravelDbCommands\Extensions\Database\Migrator
     */
    protected $migrator;

    /**
     * MigrateDropSingle constructor.
     *
     * @param \McMatters\LaravelDbCommands\Extensions\Database\Migrator $migrator
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct();

        $this->migrator = $migrator;
    }

    /**
     * Support for =< 5.4 versions.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \RuntimeException
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \RuntimeException
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->checkRequirements();

        $this->migrator->rollback(
            $this->getMigrationFile(),
            [
                'step' => count($this->migrator->getRepository()->getRan()),
                'pretend' => $this->option('pretend'),
            ]
        );

        foreach ($this->migrator->getNotes() as $note) {
            if (strpos($note, 'Migration not found') === false) {
                $this->output->writeln($note);
            }
        }
    }
}
