<?php

declare(strict_types = 1);

namespace McMatters\DbCommands\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use McMatters\DbCommands\Extenders\Database\Migrator;
use RuntimeException;

/**
 * Class MigrateSingle
 *
 * @package McMatters\DbCommands\Console\Commands
 */
class MigrateSingle extends MigrateCommand
{
    /**
     * @var string
     */
    protected $signature = 'migrate:single
        {--file : The file of migration to be executed.}
        {--class : The class name of migration.}
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
     * @throws FileNotFoundException
     * @throws RuntimeException
     */
    public function fire()
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

    /**
     * @return string
     * @throws FileNotFoundException
     */
    protected function getMigrationFile(): string
    {
        if ($this->hasOption('class')) {
            $file = $this->getFileByClass();
        } else {
            $file = $this->getMigrationPath().'/'.$this->argument('file');
        }

        if (!$file || !file_exists($file)) {
            throw new FileNotFoundException('File with migration not found.');
        }

        return $file;
    }

    /**
     * @return string|null
     */
    protected function getFileByClass()
    {
        $class = $this->option('class');

        if (!$class) {
            return null;
        }

        $class = Str::snake($class);

        $files = glob("{$this->getMigrationPath()}/[0-9_]*{$class}.php");

        return Arr::first($files);
    }

    /**
     * @return void
     * @throws RuntimeException
     */
    protected function checkRequirements()
    {
        if (!$this->hasOption('file') && !$this->hasOption('class')) {
            throw new RuntimeException('You must pass at least one argument "file" or "class"');
        }
    }
}
