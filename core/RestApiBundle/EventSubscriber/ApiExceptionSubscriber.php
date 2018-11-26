<?php

declare(strict_types=1);

namespace Core\RestApiBundle\EventSubscriber;

use Core\RestApiBundle\Exception\ApiValidationException;
use Core\RestApiBundle\Exception\UserAlreadyExistsException;
use Core\RestApiBundle\Model\ApiErrorFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public const CONTENT_TYPE = 'application/problem+json';

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onWrongUserValidation'],
                ['onRegisteredUser'],
            ],
        ];
    }

    public function onRegisteredUser(GetResponseForExceptionEvent $event): void
    {
        $e = $event->getException();

        if (!$e instanceof UserAlreadyExistsException) {
            return;
        }

        $response = ApiErrorFactory::create(
            'Given user already exists',
            ApiErrorFactory::CONFLICT
        );

        $event->setResponse(
            $response
        );
    }

    public function onWrongUserValidation(GetResponseForExceptionEvent $event): void
    {
        $e = $event->getException();

        if (!$e instanceof ApiValidationException) {
            return;
        }

        $apiProblem = $e->getApiProblem();

        $response = new JsonResponse(
            $apiProblem->toArray(),
            $apiProblem->getStatusCode()
        );

        $response = ApiErrorFactory::createResponseContentType($response);

        $event->setResponse(
            $response
        );
    }
}
