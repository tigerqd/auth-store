<?php

declare(strict_types=1);

namespace Core\UserBundle;

use Core\UserBundle\DependencyInjection\CoreUserExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreUserBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CoreUserExtension();
    }
}
