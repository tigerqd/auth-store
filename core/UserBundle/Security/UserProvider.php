<?php

declare(strict_types=1);

namespace Core\UserBundle\Security;

use Core\UserBundle\Entity\User;
use Core\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function loadUserByUsername($username): ?UserInterface
    {
        return $this->repository->findOneByNickName($username);
    }

    public function refreshUser(UserInterface $user): ?UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', \get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
