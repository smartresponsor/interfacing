<?php

declare(strict_types=1);

namespace App\Interfacing\Tests;

use App\Interfacing\Integration\Twig\InterfaceLocationTwigExtension;
use App\Interfacing\Service\Location\InterfaceLocationContextService;
use PHPUnit\Framework\TestCase;

final class InterfaceLocationTwigExtensionTest extends TestCase
{
    public function testLocationNormalizationPrefersInterfaceLocations(): void
    {
        $extension = new InterfaceLocationTwigExtension(new InterfaceLocationContextService());

        $locations = $extension->locations([
            'interface' => ['locations' => ['shell.left.middle' => [['label' => 'From interface']]]],
            'shell' => ['locations' => ['shell.left.middle' => [['label' => 'From shell']]]],
            'locations' => ['shell.left.middle' => [['label' => 'From root']]],
            'navigation' => ['locations' => ['shell.left.middle' => [['label' => 'From navigation']]]],
        ]);

        self::assertSame('From interface', $locations['shell.left.middle'][0]['label']);
    }

    public function testLocationNormalizationIgnoresNavigationFallbackAlias(): void
    {
        $extension = new InterfaceLocationTwigExtension(new InterfaceLocationContextService());

        self::assertSame([], $extension->locations([
            'navigation' => ['locations' => ['shell.context.middle' => [['label' => 'Context']]]],
        ]));
    }
}
