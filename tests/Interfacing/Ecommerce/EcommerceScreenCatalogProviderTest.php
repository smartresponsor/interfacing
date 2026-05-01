<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceScreenCatalogProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceScreenCatalogProviderTest extends TestCase
{
    public function testProvideExpandsCrudResourcesIntoCommerceScreenMatrix(): void
    {
        $crud = new class implements CrudResourceExplorerProviderInterface {
            public function provide(): array
            {
                return [
                    new CrudResourceLinkSet(
                        id: 'cataloging.product',
                        component: 'Cataloging',
                        label: 'Product',
                        resourcePath: 'product',
                        indexUrl: '/product/',
                        newUrl: '/product/new/',
                        showPattern: '/product/{id}',
                        editPattern: '/product/edit/{id}',
                        deletePattern: '/product/delete/{id}',
                        status: 'planned',
                        sampleIdentifier: 'demo',
                    ),
                ];
            }
        };

        $provider = new EcommerceScreenCatalogProvider($crud);
        $entries = $provider->provide();
        $ids = array_map(static fn ($entry): string => $entry->id(), $entries);

        self::assertContains('platform.workspace', $ids);
        self::assertContains('crud.cataloging.product.index', $ids);
        self::assertContains('crud.cataloging.product.new', $ids);
        self::assertContains('crud.cataloging.product.show', $ids);
        self::assertContains('crud.cataloging.product.edit', $ids);
        self::assertContains('crud.cataloging.product.delete', $ids);
        self::assertSame('/product/demo', $this->urlFor($entries, 'crud.cataloging.product.show'));
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
        self::assertGreaterThan(0, $provider->statusCounts()['planned']);
    }

    /** @param list<object> $entries */
    private function urlFor(array $entries, string $id): string
    {
        foreach ($entries as $entry) {
            if ($entry->id() === $id) {
                return $entry->url();
            }
        }

        self::fail('Entry not found: '.$id);
    }
}
