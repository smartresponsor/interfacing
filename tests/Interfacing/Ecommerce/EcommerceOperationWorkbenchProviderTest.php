<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceScreenEntry;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceOperationWorkbenchProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceOperationWorkbenchProviderTest extends TestCase
{
    public function testProvideCollapsesCrudActionsIntoOneOperationCard(): void
    {
        $provider = new EcommerceOperationWorkbenchProvider(new class implements EcommerceScreenCatalogProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceScreenEntry('crud.cataloging.product.index', 'Catalog and discovery', 'Cataloging', 'Product', 'index', '/product/', 'planned', 'crud'),
                    new EcommerceScreenEntry('crud.cataloging.product.new', 'Catalog and discovery', 'Cataloging', 'Product', 'new', '/product/new/', 'planned', 'crud'),
                    new EcommerceScreenEntry('crud.cataloging.product.show', 'Catalog and discovery', 'Cataloging', 'Product', 'show', '/product/sample', 'planned', 'crud-sample'),
                    new EcommerceScreenEntry('crud.cataloging.product.edit', 'Catalog and discovery', 'Cataloging', 'Product', 'edit', '/product/edit/sample', 'planned', 'crud-sample'),
                    new EcommerceScreenEntry('crud.cataloging.product.delete', 'Catalog and discovery', 'Cataloging', 'Product', 'delete', '/product/delete/sample', 'planned', 'crud-sample'),
                ];
            }

            public function groupedByZone(): array
            {
                return [];
            }

            public function statusCounts(): array
            {
                return ['connected' => 0, 'canonical' => 0, 'planned' => 5];
            }

            public function componentSummaryByZone(): array
            {
                return [];
            }
        });

        $cards = $provider->provide();

        self::assertCount(1, $cards);
        self::assertSame('crud.cataloging.product', $cards[0]->id());
        self::assertSame('/product/', $cards[0]->indexUrl());
        self::assertSame('/product/delete/sample', $cards[0]->deleteUrl());
        self::assertSame(['connected' => 0, 'canonical' => 0, 'planned' => 1, 'total' => 1], $provider->statusCounts());
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
    }
}
