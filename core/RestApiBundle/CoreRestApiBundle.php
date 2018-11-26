<?php

declare(strict_types=1);

namespace Core\RestApiBundle;

use Core\RestApiBundle\DependencyInjection\CoreRestApiExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreRestApiBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CoreRestApiExtension();
    }
}
