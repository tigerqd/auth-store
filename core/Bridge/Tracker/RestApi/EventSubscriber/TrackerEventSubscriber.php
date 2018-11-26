<?php

declare(strict_types=1);

namespace Core\Bridge\Tracker\RestApi\EventSubscriber;

use Core\MessengerBundle\Message\AnalyticsMessage;
use Core\TrackerBundle\Event\TrackerEvents;
use Core\TrackerBundle\Event\TrackEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TrackerEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var MessageBusInterface
     */
    protected $bus;

    public function __construct(TokenStorageInterface $tokenStorage, MessageBusInterface $bus)
    {
        $this->tokenStorage = $tokenStorage;
        $this->bus = $bus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TrackerEvents::TRACK_EVENT => [
                'onTrack',
            ],
        ];
    }

    public function onTrack(TrackEvent $event): void
    {
        $user = $this->getUser();
        $message = new AnalyticsMessage();
        $message->setUserId($user ? $user->getId(): 1); // @TODO
        $message->setEventType($event->getEventType());
    }

    protected function getUser(): ?UserInterface
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!\is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }
}
