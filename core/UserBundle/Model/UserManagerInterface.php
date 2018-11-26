<?php

declare(strict_types=1);

namespace Core\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserManagerInterface
{
    public function create(UserInterface $user): UserInterface;

    public function findOneByNickName(string $nickName): ?UserInterface;
}
