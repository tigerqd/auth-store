<?php

declare(strict_types=1);

namespace Core\Component\Token;

use Ramsey\Uuid\Uuid;

class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(string $salt): string
    {
        return Uuid::uuid1(sha1($salt))->serialize();
    }
}
