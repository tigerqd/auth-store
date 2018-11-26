<?php

declare(strict_types=1);

namespace Core\Component\Storage\FileSystem\Model;

use Core\Component\Storage\IncrementStrategyInterface;

class JsonIncrementStrategy implements IncrementStrategyInterface
{
    public const LAST_INSERTED = 'last_inserted';

    /**
     * @var JsonManager
     */
    protected $manager;

    public function __construct(JsonManager $manager)
    {
        $this->manager = $manager;
    }

    public function incr(string $key): int
    {
        if ($this->manager->exists($key, static::LAST_INSERTED)) {
            $insertedData = $this->manager->read($key, static::LAST_INSERTED);
            if (isset($insertedData[static::LAST_INSERTED])) {
                ++$insertedData[static::LAST_INSERTED];
            }

            $this->manager->write($key, static::LAST_INSERTED, $insertedData);

            return $insertedData[static::LAST_INSERTED];
        }

        $this->manager->write($key, static::LAST_INSERTED, [
            static::LAST_INSERTED => 1,
        ]);

        return 1;
    }
}
