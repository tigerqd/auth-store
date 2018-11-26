<?php

declare(strict_types=1);

namespace Core\Bridge\User\RestApi\EventSubscriber;

use Core\Bridge\User\RestApi\Service\UserAuthenticatorServiceInterface;
use Core\UserBundle\Event\UserLoginEvent;
use Core\UserBundle\Event\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserAuthenticatorServiceInterface
     */
    protected $authenticatorService;


    public function __construct(UserAuthenticatorServiceInterface $authenticatorService)
    {
        $this->authenticatorService = $authenticatorService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvents::USER_LOGIN_EVENT => [
                'onUserLogin',
            ],
        ];
    }

    public function onUserLogin(UserLoginEvent $event): void
    {
        $this->authenticatorService
            ->handleRequest($event->getRequest())
            ->authenticateUser($event->getUser())
        ;
    }
}
