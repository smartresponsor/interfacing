<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceAdminTableRow;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceCrudFrameProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceAdminTableProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceCrudFrameProviderTest extends TestCase
{
    public function testItBuildsNewEditAndDeleteFramesFromAdminRows(): void
    {
        $provider = new EcommerceCrudFrameProvider(new class implements EcommerceAdminTableProviderInterface {
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

        $frames = $provider->provide();

        self::assertCount(3, $frames);
        self::assertSame('new', $frames[0]->mode());
        self::assertSame('/product/new/', $frames[0]->primaryUrl());
        self::assertSame('edit', $frames[1]->mode());
        self::assertSame('/product/edit/sample', $frames[1]->primaryUrl());
        self::assertSame('delete', $frames[2]->mode());
        self::assertSame('/product/delete/sample', $frames[2]->primaryUrl());
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
        self::assertSame(['connected' => 0, 'canonical' => 0, 'planned' => 3, 'total' => 3], $provider->statusCounts());
    }
}
