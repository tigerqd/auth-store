<?php

declare(strict_types=1);

namespace Core\UserBundle\Repository;

use Core\Component\Storage\StorageInterface;
use Core\UserBundle\Entity\User;
use Core\UserBundle\Transformer\UserTransformerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserTransformerInterface
     */
    protected $transformer;

    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(UserTransformerInterface $transformer, StorageInterface $storage)
    {
        $this->transformer = $transformer;
        $this->storage = $storage;
    }

    public function findOneByNickName(string $nickName): ?UserInterface
    {
        $userData = $this->storage->findOneBy(User::TABLE, $nickName);

        return null === $userData ? null : $this->transformer->transformToObj($userData);
    }
}
