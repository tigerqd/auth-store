<?php

declare(strict_types=1);

namespace Core\TrackerBundle\Service;

use Core\TrackerBundle\Event\TrackerEvents;
use Core\TrackerBundle\Event\TrackEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Tracker implements TrackerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function track(string $eventType, array $data = []): void
    {
        $this->eventDispatcher->dispatch(
            TrackerEvents::TRACK_EVENT,
            new TrackEvent($eventType, $data)
        );
    }
}
