<?php

declare(strict_types=1);

namespace Core\Component\Token;

interface TokenGeneratorInterface
{
    public function generate(string $salt): string;
}