<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class InterfaceKernel extends BaseKernel
{
    use MicroKernelTrait;

    private static ?float $lastBootMs = null;

    public static function lastBootMs(): ?float
    {
        return self::$lastBootMs;
    }

    public function boot(): void
    {
        $startedAt = hrtime(true);
        parent::boot();
        self::$lastBootMs = (hrtime(true) - $startedAt) / 1_000_000;
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $configDir = $this->getProjectDir().'/config';

        $container->import($configDir.'/packages/*.yaml');

        $environmentPackageDir = $configDir.'/packages/'.$this->environment;
        if (is_dir($environmentPackageDir)) {
            $container->import($environmentPackageDir.'/*.yaml');
        }

        $container->import($configDir.'/services.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routeDir = $this->getProjectDir().'/config/routes';

        $routes->import($routeDir.'/*.yaml');

        $environmentRouteDir = $routeDir.'/'.$this->environment;
        if (is_dir($environmentRouteDir)) {
            $routes->import($environmentRouteDir.'/*.yaml');
        }
    }
}
