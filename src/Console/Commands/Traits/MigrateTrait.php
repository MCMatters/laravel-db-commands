<?php

declare(strict_types=1);

namespace McMatters\LaravelDbCommands\Console\Commands\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RuntimeException;

use function glob, file_exists;

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
     *
     * @throws \RuntimeException
     */
    protected function checkRequirements()
    {
        if (!$this->hasOption('file') && !$this->hasOption('class')) {
            throw new RuntimeException('You must pass at least one argument "file" or "class"');
        }
    }
}
