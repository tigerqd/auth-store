<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Controller\V1;

use Core\RestApiBundle\Controller\RestController;
use Core\RestApiBundle\Exception\AccessDeniedException;
use Core\RestApiBundle\Responder\ResponderInterface;
use Core\UserBundle\Entity\User;
use Core\UserBundle\Event\UserEvents;
use Core\UserBundle\Event\UserLoginEvent;
use Core\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractAuthController extends RestController
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var ResponderInterface
     */
    protected $responder;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(
        RequestStack $requestStack,
        UserManagerInterface $userManager,
        ResponderInterface $responder,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->requestStack = $requestStack;
        $this->userManager = $userManager;
        $this->responder = $responder;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function denyAccessIfUserLoggedIn(): void
    {
        if($this->isGranted([User::DEFAULT_ROLE])) {
            throw new AccessDeniedException('You are already logged in the system!');
        }
    }

    protected function dispatchUserLogin(UserInterface $user, Request $request): void
    {
        $this->eventDispatcher->dispatch(
            UserEvents::USER_LOGIN_EVENT,
            new UserLoginEvent($user, $request)
        );
    }
}
