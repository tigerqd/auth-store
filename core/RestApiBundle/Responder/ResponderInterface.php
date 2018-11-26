<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponderInterface
{
    public function send(): JsonResponse;
}
