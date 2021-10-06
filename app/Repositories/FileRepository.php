<?php

namespace App\Repositories;

use Illuminate\Contracts\Filesystem\Filesystem;

abstract class FileRepository
{
    protected string $path;
    protected Filesystem $filesystem;

    protected function fileExists(): bool
    {
        return $this->filesystem->exists($this->path);
    }

    abstract protected function getFileAsArray(): array;
}
