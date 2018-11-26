<?php

declare(strict_types=1);

namespace Core\MessengerBundle\Message;

class AnalyticsMessage
{
    /**
     * @var int
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

    public function toArray(): array
    {
        return [
            'id' => 1, // get prev id
            'id_user' => $this->getUserId(),
            'source_label' => $this->getEventType(),
            'date_created' => $this->getDateCreated()->format('Y-m-d H:i:s')
        ];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}

