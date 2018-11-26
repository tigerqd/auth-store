<?php

declare(strict_types=1);

namespace Core\Component\Support;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

trait BundleExtensionAwareTrait
{
    public function createYamlFileLoader(ContainerBuilder $container, string $locatorPath = ''): YamlFileLoader
    {
        if ('' === $locatorPath) {
            $locatorPath = sprintf('%s/../Resources/config', $this->getCurrentDirLocationPath());
        }

        return new YamlFileLoader($container, new FileLocator($locatorPath));
    }

    private function getCurrentDirLocationPath(): string
    {
        $reflection = new \ReflectionClass(static::class);

        return \dirname($reflection->getFileName());
    }
}
