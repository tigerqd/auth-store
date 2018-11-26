<?php

declare(strict_types=1);

namespace Core\TrackerBundle\Event;

final class TrackerEvents
{
    public const TRACK_EVENT = 'core.tracker_track';

    private function __construct()
    {
    }
}
