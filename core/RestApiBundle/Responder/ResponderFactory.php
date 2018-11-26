<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponderFactory
{
    public static function create(string $message, int $code, $data = []): JsonResponse
    {
        return  new JsonResponse(
            compact('message', 'code', 'data'),
            $code,
            [
                'Content-type' => 'application/json',
            ]
        );
    }
}