<?php

declare(strict_types=1);

namespace Core\TrackerBundle\Service;

interface TrackerInterface
{
    public function track(string $eventType, array $data = []): void;
}
