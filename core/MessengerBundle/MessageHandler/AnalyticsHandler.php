<?php

declare(strict_types=1);

namespace Core\MessengerBundle\MessageHandler;

use Core\MessengerBundle\Message\AnalyticsMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AnalyticsHandler implements MessageHandlerInterface
{
    public function __invoke(AnalyticsMessage $message)
    {
        // Emulate process of sending data to ms Analytics...
        sleep(5);
        dump($message->getData());
    }
}
