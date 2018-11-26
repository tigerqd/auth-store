<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Model;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiErrorFactory
{
    public const CONTENT_TYPE = 'application/problem+json';

    public const BAD_VALIDATION = Response::HTTP_UNPROCESSABLE_ENTITY;

    public const DENIED = Response::HTTP_FORBIDDEN;

    public const CONFLICT = Response::HTTP_CONFLICT;

    public static function create(string $message, int $code, $errors = []): JsonResponse
    {
        $response = new JsonResponse(
            compact('message', 'code', 'errors'),
            $code
        );

        return static::createResponseContentType($response);
    }

    public static function createResponseContentType(JsonResponse $response): JsonResponse
    {
        $response
            ->headers
            ->set('Content-Type', static::CONTENT_TYPE)
        ;

        return $response;
    }
}
