<?php

declare(strict_types=1);

namespace Core\Bundle\ComponentBundle;

use Core\Bundle\ComponentBundle\DependencyInjection\CoreComponentExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreComponentBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CoreComponentExtension();
    }
}
