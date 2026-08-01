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

    public function testDuplicateLocationLinksAreCollapsedBySemanticIdentity(): void
    {
        $service = new InterfaceLocationContextService();

        $locations = $service->locations([
            'interface' => [
                'locations' => [
                    'shell.header.right.quick.menu' => [
                        ['type' => 'link', 'label' => 'My Vendor', 'href' => '/my/vendor/index'],
                        ['type' => 'link', 'label' => 'My Vendor', 'href' => '/my/vendor/index'],
                        ['type' => 'link', 'label' => 'My Attachments', 'href' => '/my/attachment/index'],
                    ],
                ],
            ],
        ]);

        self::assertCount(2, $locations['shell.header.right.quick.menu']);
        self::assertSame('/my/vendor/index', $locations['shell.header.right.quick.menu'][0]['href']);
        self::assertSame('/my/attachment/index', $locations['shell.header.right.quick.menu'][1]['href']);
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
