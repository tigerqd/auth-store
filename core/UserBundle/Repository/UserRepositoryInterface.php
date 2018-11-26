<?php

declare(strict_types=1);

namespace Core\UserBundle\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserRepositoryInterface
{
    public function findOneByNickName(string $nickName): ?UserInterface;
}
