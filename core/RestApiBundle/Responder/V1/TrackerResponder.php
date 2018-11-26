<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Responder\V1;

use Core\Component\Anon\Service\AnonManagerInterface;
use Core\RestApiBundle\Responder\ResponderFactory;
use Core\RestApiBundle\Responder\ResponderInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TrackerResponder implements ResponderInterface
{
    /**
     * @var AnonManagerInterface
     */
    protected $anonManager;

    /**
     * @var string
     */
    protected $anonCookieName;

    public function __construct(AnonManagerInterface $anonManager, string $anonCookieName = 'anon_id')
    {
        $this->anonManager = $anonManager;
        $this->anonCookieName = $anonCookieName;
    }

    public function send(): JsonResponse
    {
        $response = ResponderFactory::create(
            'Track action',
            Response::HTTP_OK
        );

        if (!$response->headers->has($this->anonCookieName)) {
            $response->headers->setCookie(
                new Cookie($this->anonCookieName, $this->anonManager->getId())
            );
        }

        return $response;
    }
}
