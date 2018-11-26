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
        if ($request->getContentType() !== 'json' || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
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
