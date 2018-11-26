<?php

declare(strict_types=1);

namespace Core\Bridge\User\RestApi\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserAuthenticatorService implements UserAuthenticatorServiceInterface
{
    /**
     * @var GuardAuthenticatorHandler
     */
    protected $guard;

    /**
     * @var AuthenticatorInterface
     */
    protected $authenticator;

    /**
     * @var string
     */
    protected $providerKey;

    /**
     * @var null|Request
     */
    protected $request;

    public function __construct(
        GuardAuthenticatorHandler $guard,
        AuthenticatorInterface $authenticator,
        string $providerKey = 'main'
    )
    {
        $this->guard = $guard;
        $this->authenticator = $authenticator;
        $this->providerKey = $providerKey;
    }

    public function authenticateUser(UserInterface $user): UserAuthenticatorServiceInterface
    {
        if (null === $this->request) {
            throw new \RuntimeException('Authentication process required request handling');
        }

        $this->guard->authenticateUserAndHandleSuccess(
            $user,
            $this->request,
            $this->authenticator,
            $this->providerKey
        );

        return $this;
    }

    public function handleRequest(Request $request): UserAuthenticatorServiceInterface
    {
        $this->request = $request;

        return $this;
    }
}
