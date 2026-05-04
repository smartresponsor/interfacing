<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceOperationCard;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceCrudReadinessProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceOperationWorkbenchProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceCrudReadinessProviderTest extends TestCase
{
    public function testItDerivesReadinessItemsAndCountsFromOperationCards(): void
    {
        $provider = new EcommerceCrudReadinessProvider(new class implements EcommerceOperationWorkbenchProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceOperationCard(
                        id: 'crud.cataloging.product',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        label: 'Product',
                        resourceStatus: 'connected',
                        indexUrl: '/product/',
                        newUrl: '/product/new/',
                        showUrl: '/product/sample',
                        editUrl: '/product/edit/sample',
                        deleteUrl: '/product/delete/sample',
                        resourceKind: 'crud-resource',
                        note: 'Connected product CRUD',
                    ),
                    new EcommerceOperationCard(
                        id: 'crud.messaging.message',
                        zone: 'Messaging',
                        component: 'Messaging',
                        label: 'Message',
                        resourceStatus: 'canonical',
                        indexUrl: '/message/',
                        newUrl: '/message/new/',
                        showUrl: '/message/sample',
                        editUrl: '/message/edit/sample',
                        deleteUrl: '/message/delete/sample',
                        resourceKind: 'crud-resource',
                        note: 'Canonical message CRUD',
                    ),
                    new EcommerceOperationCard(
                        id: 'crud.tax.invoice',
                        zone: 'Tax and governance',
                        component: 'Taxating',
                        label: 'Invoice',
                        resourceStatus: 'planned',
                        indexUrl: '/invoice/',
                        newUrl: '/invoice/new/',
                        showUrl: '/invoice/sample',
                        editUrl: '/invoice/edit/sample',
                        deleteUrl: '/invoice/delete/sample',
                        resourceKind: 'crud-resource',
                        note: 'Planned invoice CRUD',
                    ),
                ];
            }

            public function groupedByZone(): array
            {
                return [];
            }

            public function statusCounts(): array
            {
                return ['connected' => 1, 'canonical' => 1, 'planned' => 1, 'total' => 3];
            }
        });

        $items = $provider->provide();

        self::assertCount(3, $items);
        self::assertSame(['ready', 'planned', 'needs_bridge'], array_map(static fn ($item) => $item->readinessGrade(), $items));
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
        self::assertSame(['ready' => 1, 'needs_bridge' => 1, 'planned' => 1, 'total' => 3], $provider->gradeCounts());
    }
}
