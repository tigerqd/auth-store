<?php

declare(strict_types=1);

namespace Core\RestApiBundle\EventSubscriber;

use Core\RestApiBundle\Exception\AccessDeniedException;
use Core\RestApiBundle\Model\ApiErrorFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AccessDeniedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handleAccessDenied'],
            ],
        ];
    }

    public function handleAccessDenied(GetResponseForExceptionEvent $event): void
    {
        $e = $event->getException();

        if (!$e instanceof AccessDeniedException) {
            return;
        }

        $response = ApiErrorFactory::create(
            $e->getMessage(),
            ApiErrorFactory::DENIED
        );

        $event->setResponse(
            $response
        );
    }
}