<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Controller\V1;

use Core\RestApiBundle\Controller\RestController;
use Core\RestApiBundle\Responder\ResponderInterface;
use Core\TrackerBundle\Service\TrackerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class TrackController extends RestController
{
    /**
     * @var TrackerInterface
     */
    protected $tracker;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ResponderInterface
     */
    protected $responder;

    /**
     * @var string
     */
    protected $eventLabelName;

    public function __construct(
        TrackerInterface $tracker,
        RequestStack $requestStack,
        ResponderInterface $responder,
        string $eventLabelName = 'source_label'
    ) {
        $this->tracker = $tracker;
        $this->requestStack = $requestStack;
        $this->responder = $responder;
        $this->eventLabelName = $eventLabelName;
    }

    /**
     * @Route("/track/", name="track", methods={"GET"})
     *
     * @throws \HttpRuntimeException
     */
    public function track(): JsonResponse
    {
        $request = $this->requestStack->getCurrentRequest();
        $this->validateRequest($request);

        if ($request->query->has($this->eventLabelName)) {
            $this->tracker->track(
                $request->query->get($this->eventLabelName, '')
            );
        }

        return $this->responder->send();
    }
}
