<?php

declare(strict_types=1);

namespace Core\TrackerBundle;

use Core\TrackerBundle\DependencyInjection\CoreTrackerExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreTrackerBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CoreTrackerExtension();
    }
}
