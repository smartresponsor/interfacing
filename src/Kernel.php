<?php

declare(strict_types=1);

namespace App\Interfacing;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
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
        $container->import($configDir.'/packages/'.$this->environment.'/*.yaml');
        $container->import($configDir.'/services.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $configDir = $this->getProjectDir().'/config/routes';

        $routes->import($configDir.'/*.yaml');
        $routes->import($configDir.'/'.$this->environment.'/*.yaml');
    }
}
