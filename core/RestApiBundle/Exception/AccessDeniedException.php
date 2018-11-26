<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Exception;

use Throwable;

class AccessDeniedException extends \RuntimeException
{
    public function __construct(
        string $message = 'Access denied',
        int $code = 403,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}