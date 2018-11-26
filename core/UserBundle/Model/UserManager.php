<?php

declare(strict_types=1);

namespace Core\UserBundle\Model;

use Core\Component\Storage\Exception\DuplicateRecordException;
use Core\Component\Storage\StorageInterface;
use Core\RestApiBundle\Exception\UserAlreadyExistsException;
use Core\UserBundle\Entity\User;
use Core\UserBundle\Repository\UserRepositoryInterface;
use Core\UserBundle\Transformer\UserTransformerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager implements UserManagerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var UserTransformerInterface
     */
    protected $transformer;

    /**
     * @var PasswordEncoderInterface
     */
    protected $encoder;


    public function __construct(
        UserRepositoryInterface $repository,
        StorageInterface $storage,
        UserTransformerInterface $transformer,
        PasswordEncoderInterface $encoder
    )
    {
        $this->repository = $repository;
        $this->storage = $storage;
        $this->transformer = $transformer;
        $this->encoder = $encoder;
    }

    public function create(UserInterface $user): UserInterface
    {
        try {
            $encoded = $this
                ->encoder
                ->encodePassword($user->getPassword(), $user->getSalt())
            ;

            $user->setPassword($encoded);
            $this->storage->create(
                User::TABLE,
                $user->getUsername(),
                $this->transformer->transformToRow($user)
            );

            return $user;
        } catch (DuplicateRecordException $exception) {
            throw new UserAlreadyExistsException('User with this nick already created!');
        }
    }

    public function findOneByNickName(string $nickName): ?UserInterface
    {
        return $this->repository->findOneByNickName($nickName);
    }
}
