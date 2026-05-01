<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceOperationCard;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceAdminTableProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceOperationWorkbenchProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceAdminTableProviderTest extends TestCase
{
    public function testItBuildsTableRowsFromOperationCards(): void
    {
        $provider = new EcommerceAdminTableProvider(new class implements EcommerceOperationWorkbenchProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceOperationCard(
                        id: 'crud.cataloging.product',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        label: 'Product',
                        resourceStatus: 'planned',
                        indexUrl: '/product/',
                        newUrl: '/product/new/',
                        showUrl: '/product/sample',
                        editUrl: '/product/edit/sample',
                        deleteUrl: '/product/delete/sample',
                        resourceKind: 'crud-resource',
                        note: 'Product table contract.',
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

        $rows = $provider->provide();

        self::assertCount(1, $rows);
        self::assertSame('Cataloging', $rows[0]->component());
        self::assertSame('/product/', $rows[0]->indexUrl());
        self::assertSame('sample', $rows[0]->identifierPreview());
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
        self::assertSame(['connected' => 0, 'canonical' => 0, 'planned' => 1, 'total' => 1], $provider->statusCounts());
    }
}
