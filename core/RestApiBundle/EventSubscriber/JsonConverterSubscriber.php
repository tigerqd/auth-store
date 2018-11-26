<?php

declare(strict_types=1);

namespace Core\RestApiBundle\EventSubscriber;

use Core\Component\Request\JsonConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonConverterSubscriber implements EventSubscriberInterface
{
    /**
     * @var JsonConverter
     */
    protected $converter;

    public function __construct(JsonConverter $converter)
    {
        $this->converter = $converter;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                'convert',
            ],
        ];
    }

    public function convert(FilterControllerEvent $event): void
    {
        $this->converter->convert($event->getRequest());
    }
}
