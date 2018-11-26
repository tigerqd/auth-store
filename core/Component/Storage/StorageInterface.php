<?php

declare(strict_types=1);

namespace Core\Component\Storage;

interface StorageInterface
{
    public function create(string $storageField, string $key, array $data): array;

    public function findOneBy(string $storageField, string $row): ?array;

    public function exists(string $storageField, string $row): bool;
}
