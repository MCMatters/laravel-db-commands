<?php

declare(strict_types=1);

namespace McMatters\LaravelDbCommands\Console\Commands\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RuntimeException;

use function glob, file_exists, method_exists;

use const null;

/**
 * Trait MigrateTrait
 *
 * @package McMatters\LaravelDbCommands\Console\Commands\Traits
 */
trait MigrateTrait
{
    /**
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getMigrationFile(): string
    {
        if ($class = $this->option('class')) {
            $file = $this->getFileByClass($class);
        } else {
            $file = $this->getMigrationPath().'/'.$this->option('file');
        }

        if (!$file || !file_exists($file)) {
            throw new FileNotFoundException('File with migration not found.');
        }

        return $file;
    }

    /**
     * @param string|null $class
     *
     * @return string|null
     */
    protected function getFileByClass(string $class = null)
    {
        if (!$class) {
            return null;
        }

        $class = Str::snake($class);

        $files = glob("{$this->getMigrationPath()}/[0-9_]*{$class}.php");

        return Arr::first($files);
    }

    /**
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function checkRequirements()
    {
        if (!$this->hasOption('file') && !$this->hasOption('class')) {
            throw new RuntimeException('You must pass at least one argument "file" or "class"');
        }
    }

    /**
     * @return void
     */
    protected function setMigratorOutput()
    {
        // Works only for 5.7+
        if (method_exists($this->migrator, 'setOutput')) {
            $this->migrator->setOutput($this->getOutput());
        }
    }

    /**
     * @param callable|null $when
     *
     * @return void
     */
    protected function writeMigratorNotes(callable $when = null)
    {
        // Support for 5.2-5.6
        if (method_exists($this->migrator, 'getNotes')) {
            foreach ($this->migrator->getNotes() as $note) {
                if (null === $when || $when($note)) {
                    $this->output->writeln($note);
                }
            }
        }
    }
}
