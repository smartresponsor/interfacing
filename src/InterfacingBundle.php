<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing;

use App\Interfacing\Integration\Symfony\Compiler\InterfaceAttributeTagCompilerPass;
use App\Interfacing\Integration\Symfony\Compiler\InterfaceCatalogCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class InterfacingBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new InterfaceAttributeTagCompilerPass());
        $container->addCompilerPass(new InterfaceCatalogCompilerPass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
