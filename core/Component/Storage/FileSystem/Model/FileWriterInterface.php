<?php

declare(strict_types=1);

namespace Core\Component\Storage\FileSystem\Model;

interface FileWriterInterface
{
    public function write(string $storageField, string $key, array $data): void;
}
