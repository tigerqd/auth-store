<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Responder\V1;

use Core\RestApiBundle\Responder\ResponderFactory;
use Core\RestApiBundle\Responder\ResponderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponder implements ResponderInterface
{
    public function send(): JsonResponse
    {
        return ResponderFactory::create(
            'Success register action',
            Response::HTTP_OK
        );
    }
}
