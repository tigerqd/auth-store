<?php

declare(strict_types=1);

namespace Core\Component\Request;

use Symfony\Component\HttpFoundation\Request;
use function json_last_error;
use function json_last_error_msg;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonConverter
{
    public function convert(Request $request): void
    {
        if ('json' !== $request->getContentType() || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException(
                sprintf(
                    'invalid json body: %s',
                    json_last_error_msg()
                )
            );
        }

        $request->request->replace(\is_array($data) ? $data : []);
    }
}
