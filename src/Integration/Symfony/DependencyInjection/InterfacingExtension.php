<?php

declare(strict_types=1);

namespace App\Interfacing\Integration\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class InterfacingExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        $projectDir = dirname(__DIR__, 4);

        if ($container->hasExtension('twig')) {
            $container->prependExtensionConfig('twig', [
                'paths' => [
                    $projectDir.'/template' => '',
                    $projectDir.'/templates' => '',
                ],
            ]);
        }
    }

    /**
     * @param array<array-key, mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configDir = dirname(__DIR__, 4).'/config';
        $loader = new YamlFileLoader($container, new FileLocator($configDir));

        $loader->load('services.yaml');

        foreach (glob($configDir.'/services/*.yaml') ?: [] as $serviceFile) {
            $loader->load('services/'.basename($serviceFile));
        }
    }
}
