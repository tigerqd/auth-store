<?php

declare(strict_types=1);

namespace Core\TrackerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class TrackEvent extends Event
{
    /**
     * @var string
     */
    private $eventType;

    /**
     * @var array
     */
    private $data;

    public function __construct(string $eventType, array $data = [])
    {
        $this->eventType = $eventType;
        $this->data = $data;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): void
    {
        $this->eventType = $eventType;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
