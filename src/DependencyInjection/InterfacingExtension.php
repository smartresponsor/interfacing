<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class InterfacingExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('twig')) {
            $templateDir = \dirname(__DIR__, 2).'/template';
            $container->prependExtensionConfig('twig', ['paths' => [$templateDir => 'Interfacing']]);
            $container->prependExtensionConfig('twig', ['paths' => [$templateDir => 'interfacing']]);
        }
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__, 2).'/config/services'));

        $loader->load('interfacing.yaml');

        $container->setParameter('interfacing.package_dir', \dirname(__DIR__, 2));
        $container->setParameter('interfacing.template_dir', \dirname(__DIR__, 2).'/template');
    }
}
