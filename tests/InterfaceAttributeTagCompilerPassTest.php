<?php

declare(strict_types=1);

namespace App\Interfacing\Tests;

use App\Interfacing\Integration\Symfony\Compiler\InterfaceAttributeTagCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class InterfaceAttributeTagCompilerPassTest extends TestCase
{
    public function testVendorDefinitionsAreNotAutoloadedDuringAttributeDiscovery(): void
    {
        $container = new ContainerBuilder();
        $container->register('vendor.optional_service', 'Vendor\\Optional\\ExplodingService');

        $autoloaded = false;
        $loader = static function (string $class) use (&$autoloaded): void {
            if ('Vendor\\Optional\\ExplodingService' !== $class) {
                return;
            }

            $autoloaded = true;
            throw new \RuntimeException('Vendor definition must not be autoloaded by Interfacing attribute discovery.');
        };

        spl_autoload_register($loader, prepend: true);

        try {
            (new InterfaceAttributeTagCompilerPass())->process($container);
        } finally {
            spl_autoload_unregister($loader);
        }

        self::assertFalse($autoloaded);
        self::assertSame([], $container->getDefinition('vendor.optional_service')->getTags());
    }
}
