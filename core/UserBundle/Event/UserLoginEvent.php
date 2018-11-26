<?php

declare(strict_types=1);

namespace Core\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserLoginEvent extends Event
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(UserInterface $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
