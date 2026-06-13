<?php

declare(strict_types=1);

namespace App\Interfacing\Tests;

use App\Interfacing\Integration\Twig\InterfaceLocationTwigExtension;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class InterfaceLocationTwigExtensionTest extends TestCase
{
    public function testLocationNormalizationPrefersInterfaceLocations(): void
    {
        $extension = new InterfaceLocationTwigExtension(new Environment(new ArrayLoader([])));

        $locations = $extension->locations([
            'interface' => ['locations' => ['shell.left.middle' => [['label' => 'From interface']]]],
            'shell' => ['locations' => ['shell.left.middle' => [['label' => 'From shell']]]],
            'locations' => ['shell.left.middle' => [['label' => 'From root']]],
            'navigation' => ['locations' => ['shell.left.middle' => [['label' => 'From navigation']]]],
        ]);

        self::assertSame('From interface', $locations['shell.left.middle'][0]['label']);
    }

    public function testLocationNormalizationKeepsLegacyNavigationFallback(): void
    {
        $extension = new InterfaceLocationTwigExtension(new Environment(new ArrayLoader([])));

        $locations = $extension->locations([
            'navigation' => ['locations' => ['shell.context.middle' => [['label' => 'Context']]]],
        ]);

        self::assertSame('Context', $locations['shell.context.middle'][0]['label']);
    }
}
