<?php

declare(strict_types=1);

namespace Core\Component\Storage\FileSystem\Model;

use Core\Component\Storage\StorageInterface;
use Core\Component\Storage\Exception\DuplicateRecordException;

class JsonStorage implements StorageInterface
{
    /**
     * @var JsonManager
     */
    protected $manager;

    public function __construct(JsonManager $manager)
    {
        $this->manager = $manager;
    }

    public function create(string $storageField, string $key, array $data): void
    {
        if ($this->exists($storageField, $key)) {
            throw new DuplicateRecordException(
                'Duplicate file record, it can break program logic.'
            );
        }

        // @TODO autoincrement strategy
       $this->manager->write($storageField, $key, $data);
    }

    public function findOneBy(string $storageField, string $row): ?array
    {
        try {
            return $this->manager->read($storageField, $row);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function exists(string $storageField, string $row): bool
    {
        return $this->manager->exists($storageField, $row);
    }
}
