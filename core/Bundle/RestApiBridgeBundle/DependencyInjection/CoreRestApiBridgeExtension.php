<?php

declare(strict_types=1);

namespace Core\Bundle\RestApiBridgeBundle\DependencyInjection;

use Core\Component\Support\BundleExtensionAwareTrait;
use Core\UserBundle\CoreUserBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class CoreRestApiBridgeExtension extends Extension
{
    use BundleExtensionAwareTrait;

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = $this->createYamlFileLoader($container);

        $bundles = $container->getParameter('kernel.bundles');

        if (\in_array(CoreUserBundle::class, $bundles, true)) {
            // include bridge components if target bundle included
            $loader->load('user/services.yaml');
            $loader->load('tracker/services.yaml');
        }
    }
}
