<?php

declare(strict_types=1);

namespace Core\MessengerBundle;

use Core\MessengerBundle\DependencyInjection\CoreMessengerExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreMessengerBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CoreMessengerExtension();
    }
}
