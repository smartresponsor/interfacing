<?php

declare(strict_types=1);

namespace App\Interfacing\Tests;

use App\Interfacing\Service\Location\InterfaceLocationContextService;
use PHPUnit\Framework\TestCase;

final class InterfaceLocationContextServiceTest extends TestCase
{
    public function testReadsOnlyCanonicalInterfaceLocations(): void
    {
        $service = new InterfaceLocationContextService();

        $locations = $service->locations([
            'interface' => [
                'locations' => [
                    'shell.left.middle' => [[
                        'type' => 'link',
                        'label' => 'Catalog',
                        'href' => '/catalog/product/index',
                    ]],
                ],
            ],
            'locations' => [
                'shell.left.middle' => [['label' => 'Ignored root location']],
            ],
        ]);

        self::assertSame('Catalog', $locations['shell.left.middle'][0]['label'] ?? null);
    }

    public function testRootLocationsAreNotFallback(): void
    {
        $service = new InterfaceLocationContextService();

        self::assertSame([], $service->locations([
            'locations' => [
                'shell.left.middle' => [['label' => 'Not canonical']],
            ],
        ]));
    }
}
