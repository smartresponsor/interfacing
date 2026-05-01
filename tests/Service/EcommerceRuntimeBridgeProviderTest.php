<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Contract\View\EcommerceComponentRoadmapItem;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceRuntimeBridgeProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceRuntimeBridgeProviderTest extends TestCase
{
    public function testItBuildsRuntimeBridgeItemsFromRoadmap(): void
    {
        $provider = new EcommerceRuntimeBridgeProvider(new class implements EcommerceComponentRoadmapProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceComponentRoadmapItem(
                        id: 'cataloging',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        status: 'canonical',
                        primaryUrl: '/product/',
                        ownership: 'Cataloging owns product records.',
                        screen: ['Products'],
                        resource: ['product'],
                        note: 'Cataloging must provide runtime bridge.',
                    ),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Catalog and discovery' => $this->provide()];
            }

            public function statusCounts(): array
            {
                return ['connected' => 0, 'canonical' => 1, 'planned' => 0, 'total' => 1];
            }
        });

        $items = $provider->provide();

        self::assertCount(1, $items);
        self::assertSame('Cataloging', $items[0]->component());
        self::assertSame('needs_bridge', $items[0]->bridgeGrade());
        self::assertNotEmpty($items[0]->routeBridge());
        self::assertNotEmpty($items[0]->controllerBridge());
        self::assertNotEmpty($items[0]->queryBridge());
        self::assertNotEmpty($items[0]->commandBridge());
        self::assertNotEmpty($items[0]->policyBridge());
        self::assertNotEmpty($items[0]->evidenceBridge());
        self::assertStringContainsString('Add host route', $items[0]->promotionGate());
    }

    public function testItCountsRuntimeBridgeGrades(): void
    {
        $provider = new EcommerceRuntimeBridgeProvider(new class implements EcommerceComponentRoadmapProviderInterface {
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
                    note: $component.' bridge state.',
                );
            }
        });

        self::assertSame(['ready' => 1, 'needs_bridge' => 1, 'planned' => 1, 'total' => 3], $provider->gradeCounts());
    }
}
