<?php

declare(strict_types=1);

namespace Core\RestApiBundle\EventSubscriber;

use Core\RestApiBundle\Exception\IncorrectUserNickNameException;
use Core\RestApiBundle\Model\ApiErrorFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class WrongLoginDataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handleIncorrectUserNickName'],
            ],
        ];
    }

    public function handleIncorrectUserNickName(GetResponseForExceptionEvent $event): void
    {
        $e = $event->getException();

        if (!$e instanceof IncorrectUserNickNameException) {
            return;
        }

        $response = ApiErrorFactory::create(
            $e->getMessage(),
            ApiErrorFactory::BAD_VALIDATION,
            ['field' => 'nickname']
        );

        $event->setResponse(
            $response
        );
    }
}
