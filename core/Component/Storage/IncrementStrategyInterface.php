<?php

declare(strict_types=1);

namespace Core\Component\Storage;

interface IncrementStrategyInterface
{
    public function incr(string $key): int;
}
