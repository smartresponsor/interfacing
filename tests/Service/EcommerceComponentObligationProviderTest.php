<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Contract\View\EcommerceComponentRoadmapItem;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceComponentObligationProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceComponentObligationProviderTest extends TestCase
{
    public function testItBuildsComponentObligationItemsFromRoadmap(): void
    {
        $provider = new EcommerceComponentObligationProvider(new class implements EcommerceComponentRoadmapProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceComponentRoadmapItem(
                        id: 'cataloging',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        status: 'connected',
                        primaryUrl: '/category/',
                        ownership: 'Cataloging owns records.',
                        screen: ['Products', 'Categories'],
                        resource: ['product', 'category'],
                        note: 'Cataloging must provide fixtures/providers.',
                    ),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Catalog and discovery' => $this->provide()];
            }

            public function statusCounts(): array
            {
                return ['connected' => 1, 'canonical' => 0, 'planned' => 0, 'total' => 1];
            }
        });

        $items = $provider->provide();

        self::assertCount(1, $items);
        self::assertSame('Cataloging', $items[0]->component());
        self::assertSame('low', $items[0]->riskLevel());
        self::assertContains('Products', $items[0]->requiredScreens());
        self::assertContains('product', $items[0]->requiredResources());
        self::assertContains('component fixtures/providers remain the only source for records', $items[0]->fixtureObligations());
        self::assertContains('controller/bridge routes matching the canonical CRUD grammar', $items[0]->runtimeObligations());
    }

    public function testItCountsRiskLevels(): void
    {
        $provider = new EcommerceComponentObligationProvider(new class implements EcommerceComponentRoadmapProviderInterface {
            public function provide(): array
            {
                return [
                    $this->item('cataloging', 'Cataloging', 'connected'),
                    $this->item('taxating', 'Taxating', 'canonical'),
                    $this->item('shipping', 'Shipping', 'planned'),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Platform operations' => $this->provide()];
            }

            public function statusCounts(): array
            {
                return ['connected' => 1, 'canonical' => 1, 'planned' => 1, 'total' => 3];
            }

            private function item(string $id, string $component, string $status): EcommerceComponentRoadmapItem
            {
                return new EcommerceComponentRoadmapItem(
                    id: $id,
                    zone: 'Platform operations',
                    component: $component,
                    status: $status,
                    primaryUrl: '/'.$id.'/',
                    ownership: $component.' owns records.',
                    screen: [$component.' screen'],
                    resource: [$id],
                    note: $component.' must provide data.',
                );
            }
        });

        self::assertSame(['high' => 1, 'medium' => 1, 'low' => 1, 'total' => 3], $provider->riskCounts());
    }
}
