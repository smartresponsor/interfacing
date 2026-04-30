<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Integration\Symfony\Compiler;

use App\Interfacing\Service\Interfacing\Registry\ActionCatalog;
use App\Interfacing\Service\Interfacing\Registry\ScreenCatalog;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class InterfacingCatalogCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(ScreenCatalog::class) || !$container->hasDefinition(ActionCatalog::class)) {
            return;
        }

        $screenDef = $container->getDefinition(ScreenCatalog::class);
        $actionDef = $container->getDefinition(ActionCatalog::class);

        foreach ($container->findTaggedServiceIds(InterfacingAttributeTagCompilerPass::TAG_SCREEN) as $serviceId => $tagList) {
            $screenDef->addMethodCall('add', [new Reference($serviceId)]);
        }

        foreach ($container->findTaggedServiceIds(InterfacingAttributeTagCompilerPass::TAG_ACTION) as $serviceId => $tagList) {
            $actionDef->addMethodCall('add', [new Reference($serviceId)]);
        }
    }
}
