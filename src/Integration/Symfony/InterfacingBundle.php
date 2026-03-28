<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Integration\Symfony;

use App\Integration\Symfony\Compiler\InterfacingAttributeTagCompilerPass;
use App\Integration\Symfony\Compiler\InterfacingCatalogCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class InterfacingBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new InterfacingAttributeTagCompilerPass());
        $container->addCompilerPass(new InterfacingCatalogCompilerPass());
    }
}
