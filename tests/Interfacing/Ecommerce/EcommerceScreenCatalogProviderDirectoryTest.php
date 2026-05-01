<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceScreenCatalogProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceScreenCatalogProviderDirectoryTest extends TestCase
{
    public function testComponentSummaryGroupsScreensByZone(): void
    {
        $provider = new EcommerceScreenCatalogProvider(new class implements CrudResourceExplorerProviderInterface {
            public function provide(): array
            {
                return [
                    new CrudResourceLinkSet(
                        id: 'cataloging.product',
                        component: 'Cataloging',
                        label: 'Products',
                        resourcePath: 'product',
                        status: 'planned',
                    ),
                ];
            }
        });

        $groups = $provider->componentSummaryByZone();

        self::assertArrayHasKey('Catalog and discovery', $groups);
        self::assertSame('Cataloging', $groups['Catalog and discovery'][0]->component());
        self::assertSame(5, $groups['Catalog and discovery'][0]->total());
        self::assertSame('planned', $groups['Catalog and discovery'][0]->primaryStatus());
    }
}
