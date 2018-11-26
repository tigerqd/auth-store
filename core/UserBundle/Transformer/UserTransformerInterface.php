<?php

declare(strict_types=1);

namespace Core\UserBundle\Transformer;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserTransformerInterface
{
    public function transformToObj(array $data): UserInterface;

    public function transformToRow(UserInterface $user): array;
}
