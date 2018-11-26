<?php

declare(strict_types=1);

namespace Core\Bundle\ComponentBundle\DependencyInjection;

use Core\Component\Support\BundleExtensionAwareTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class CoreComponentExtension extends Extension
{
    use BundleExtensionAwareTrait;

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = $this->createYamlFileLoader($container);

        $loader->load('services.yaml');
    }
}
