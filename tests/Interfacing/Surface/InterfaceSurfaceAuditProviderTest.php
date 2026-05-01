<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Surface;

use App\Interfacing\Contract\View\EcommerceScreenEntry;
use App\Interfacing\Service\Interfacing\Surface\InterfaceSurfaceAuditProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;
use PHPUnit\Framework\TestCase;

final class InterfaceSurfaceAuditProviderTest extends TestCase
{
    public function testProvideExposesShellCrudAndDataBoundaryChecks(): void
    {
        $provider = new InterfaceSurfaceAuditProvider(new class implements EcommerceScreenCatalogProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceScreenEntry('crud.cataloging.product.index', 'Catalog and discovery', 'Cataloging', 'Product', 'index', '/product/', 'planned', 'crud'),
                    new EcommerceScreenEntry('crud.messaging.message.index', 'Messaging', 'Messaging', 'Message', 'index', '/message/', 'connected', 'crud'),
                ];
            }

            public function groupedByZone(): array
            {
                return [];
            }

            public function statusCounts(): array
            {
                return ['connected' => 1, 'canonical' => 0, 'planned' => 1];
            }

            public function componentSummaryByZone(): array
            {
                return [];
            }
        });

        $items = $provider->provide();
        $ids = array_map(static fn ($item): string => $item->id(), $items);

        self::assertContains('shell.workspace', $ids);
        self::assertContains('crud.grammar.index', $ids);
        self::assertContains('data.boundary.fixtures', $ids);
        self::assertContains('component.cataloging', $ids);
        self::assertArrayHasKey('Shell coverage', $provider->groupedByArea());
        self::assertGreaterThan(0, $provider->statusCounts()['solid']);
        self::assertGreaterThan(0, $provider->statusCounts()['watch']);
    }
}
