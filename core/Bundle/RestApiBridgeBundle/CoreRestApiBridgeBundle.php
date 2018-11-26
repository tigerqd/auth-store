<?php

declare(strict_types=1);

namespace Core\Bundle\RestApiBridgeBundle;

use Core\Bundle\RestApiBridgeBundle\DependencyInjection\CoreRestApiBridgeExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreRestApiBridgeBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CoreRestApiBridgeExtension();
    }
}
