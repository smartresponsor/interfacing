<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceAdminTableRow;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceCrudAffordanceProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceAdminTableProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceCrudAffordanceProviderTest extends TestCase
{
    public function testItBuildsFilterSortAndBulkAffordancesFromAdminRows(): void
    {
        $provider = new EcommerceCrudAffordanceProvider(new class implements EcommerceAdminTableProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceAdminTableRow(
                        id: 'crud.cataloging.product',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        resourceLabel: 'Product',
                        status: 'planned',
                        indexUrl: '/product/',
                        newUrl: '/product/new/',
                        showUrl: '/product/sample',
                        editUrl: '/product/edit/sample',
                        deleteUrl: '/product/delete/sample',
                        identifierPreview: 'sample',
                        emptyStateTitle: 'No products',
                        emptyStateText: 'Cataloging owns product records.',
                    ),
                ];
            }

            public function groupedByZone(): array
            {
                return [];
            }

            public function statusCounts(): array
            {
                return ['connected' => 0, 'canonical' => 0, 'planned' => 1, 'total' => 1];
            }
        });

        $affordances = $provider->provide();

        self::assertCount(3, $affordances);
        self::assertSame('filter-search', $affordances[0]->type());
        self::assertSame('/product/?q=', $affordances[0]->primaryUrl());
        self::assertSame('sort-pagination', $affordances[1]->type());
        self::assertSame('/product/?sort=id&direction=asc&page=1', $affordances[1]->primaryUrl());
        self::assertSame('bulk-actions', $affordances[2]->type());
        self::assertStringContainsString('#bulk-actions', $affordances[2]->primaryUrl());
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
        self::assertSame(['connected' => 0, 'canonical' => 0, 'planned' => 3, 'total' => 3], $provider->statusCounts());
    }
}
