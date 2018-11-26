<?php

declare(strict_types=1);

namespace Core\MessengerBundle\Message;

class AnalyticsMessage
{
    /**
     * @var string|int
     */
    private $userId;

    /**
     * @var string
     */
    private $eventType;

    public function setEventType(string $eventType): void
    {
        $this->eventType = $eventType;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getDateCreated(): \DateTime
    {
        return new \DateTime();
    }

    public function getData(): array
    {
        return [
            'id' => uniqid('_analytics_event_', true),
            'id_user' => $this->getUserId(),
            'source_label' => $this->getEventType(),
            'date_created' => $this->getDateCreated()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return int|string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int|string $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }
}
