<?php

declare(strict_types=1);

namespace Core\Bridge\User\RestApi\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserAuthenticatorServiceInterface
{
    public function handleRequest(Request $request): self;

    public function authenticateUser(UserInterface $user): self;
}
