<?php

declare(strict_types=1);

namespace Core\Component\Token;

use Ramsey\Uuid\Uuid;

class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(string $salt): string
    {
       return (string) Uuid::uuid5(
           __NAMESPACE__, sha1($salt.\time())
       );
    }
}
