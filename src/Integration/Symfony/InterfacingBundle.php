<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Integration\Symfony;

use App\Interfacing\Integration\Symfony\Compiler\InterfacingAttributeTagCompilerPass;
use App\Interfacing\Integration\Symfony\Compiler\InterfacingCatalogCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class InterfacingBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__, 3);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new InterfacingAttributeTagCompilerPass());
        $container->addCompilerPass(new InterfacingCatalogCompilerPass());
    }
}
