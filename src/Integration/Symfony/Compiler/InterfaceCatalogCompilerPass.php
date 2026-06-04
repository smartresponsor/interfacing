<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Integration\Symfony\Compiler;

use App\Interfacing\Catalog\AttributeRegistry\InterfaceActionCatalog;
use App\Interfacing\Catalog\AttributeRegistry\InterfaceScreenCatalog;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class InterfaceCatalogCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(InterfaceScreenCatalog::class) || !$container->hasDefinition(InterfaceActionCatalog::class)) {
            return;
        }

        $screenDef = $container->getDefinition(InterfaceScreenCatalog::class);
        $actionDef = $container->getDefinition(InterfaceActionCatalog::class);

        foreach ($container->findTaggedServiceIds(InterfaceAttributeTagCompilerPass::TAG_SCREEN) as $serviceId => $tagList) {
            $screenDef->addMethodCall('add', [new Reference($serviceId)]);
        }

        foreach ($container->findTaggedServiceIds(InterfaceAttributeTagCompilerPass::TAG_ACTION) as $serviceId => $tagList) {
            $actionDef->addMethodCall('add', [new Reference($serviceId)]);
        }
    }
}
