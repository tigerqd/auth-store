<?php

declare(strict_types=1);

namespace Core\Component\Storage\FileSystem\Model;

use Core\Component\Storage\IncrementStrategyInterface;
use Core\Component\Storage\StorageInterface;
use Core\Component\Storage\Exception\DuplicateRecordException;

class JsonStorage implements StorageInterface
{
    /**
     * @var JsonManager
     */
    protected $manager;

    /**
     * @var IncrementStrategyInterface
     */
    protected $incrementStrategy;

    public function __construct(JsonManager $manager, IncrementStrategyInterface $incrementStrategy)
    {
        $this->manager = $manager;
        $this->incrementStrategy = $incrementStrategy;
    }

    public function create(string $storageField, string $key, array $data): array
    {
        if ($this->exists($storageField, $key)) {
            throw new DuplicateRecordException(
                'Duplicate file record, it can break program logic.'
            );
        }

        $data['id'] = $this->incrementStrategy->incr($storageField);
        $this->manager->write($storageField, $key, $data);

        return $data;
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
