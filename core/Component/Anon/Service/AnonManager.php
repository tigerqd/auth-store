<?php

declare(strict_types=1);

namespace Core\Component\Anon\Service;

use Core\Component\Token\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AnonManager implements AnonManagerInterface
{
    public static $id = '';

    /**
     * @var TokenGeneratorInterface
     */
    protected $generator;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var string
     */
    protected $anonCookieName;

    public function __construct(TokenGeneratorInterface $generator, RequestStack $requestStack, string $anonCookieName)
    {
        $this->generator = $generator;
        $this->requestStack = $requestStack;
        $this->anonCookieName = $anonCookieName;
    }

    public function getId(): string
    {
        if ('' !== static::$id) {
            return static::$id;
        }

        if ($anonId = $this->getAnonIdFromRequest()) {
            return static::$id = $anonId;
        }

        return static::$id = $this->generator->generate(
            sprintf('_anon_user_%s_%s', time(), uniqid('_user', true))
        );
    }

    protected function getAnonIdFromRequest(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null === $request) {
            return null;
        }

        return $request->cookies->get($this->anonCookieName);
    }
}
