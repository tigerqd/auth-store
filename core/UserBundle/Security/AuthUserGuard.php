<?php

declare(strict_types=1);

namespace Core\UserBundle\Security;

use Core\Component\Request\JsonConverter;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class AuthUserGuard extends AbstractGuardAuthenticator
{
    public const GUARD_URIS = [
        'api/v1/login',
    ];

    /**
     * @var JsonConverter
     */
    protected $converter;

    public function setJsonConverter(JsonConverter $converter): void
    {
        $this->converter = $converter;
    }

    public function supports(Request $request): bool
    {
       if (\in_array(trim($request->getPathInfo(), '/'), static::GUARD_URIS, true)) {
           return true;
       }

        return false;
    }

    public function getCredentials(Request $request): array
    {
        $this->converter->convert($request);

        if (!$nickname = $request->request->get('nickname')) {
            $nickname = null;
        }

        return compact('nickname');
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        $nickname = $credentials['nickname'];

        if (null === $nickname) {
            return null;
        }

        return $userProvider->loadUserByUsername($nickname);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): void
    {
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(
            $this->getDataMessage($exception),
            Response::HTTP_FORBIDDEN
        );
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Authentication is required',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return true;
    }

    private function getDataMessage(?AuthenticationException $exception): array
    {

        if(null === $exception) {
            return [];
        }

        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        if ('Username could not be found.' === $data['message']) {
            $data['message'] = 'Invalid user nickname provided, user cannot be loaded.';
        }

        return $data;

    }
}
