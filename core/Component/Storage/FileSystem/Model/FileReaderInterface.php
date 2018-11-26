<?php

declare(strict_types=1);

namespace Core\Component\Storage\FileSystem\Model;

interface FileReaderInterface
{
    public function exists(string $storageField, string $file): bool;

    public function read(string $storageField, string $file): ?array;
}
