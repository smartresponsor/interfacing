<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Contract\View\EcommerceRuntimeBridgeItem;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommercePromotionGateProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceRuntimeBridgeProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommercePromotionGateProviderTest extends TestCase
{
    public function testItBuildsPromotionGateItemsFromRuntimeBridges(): void
    {
        $provider = new EcommercePromotionGateProvider(new class implements EcommerceRuntimeBridgeProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommerceRuntimeBridgeItem(
                        id: 'cataloging.runtime-bridge',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        status: 'canonical',
                        bridgeGrade: 'needs_bridge',
                        primaryUrl: '/product/',
                        routeBridge: ['route bridge'],
                        controllerBridge: ['controller bridge'],
                        queryBridge: ['query bridge'],
                        commandBridge: ['command bridge'],
                        policyBridge: ['policy bridge'],
                        evidenceBridge: ['evidence bridge'],
                        promotionGate: 'Add host route bridge.',
                        note: 'Cataloging bridge state.',
                    ),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Catalog and discovery' => $this->provide()];
            }

            public function gradeCounts(): array
            {
                return ['ready' => 0, 'needs_bridge' => 1, 'planned' => 0, 'total' => 1];
            }
        });

        $items = $provider->provide();

        self::assertCount(1, $items);
        self::assertSame('Cataloging', $items[0]->component());
        self::assertSame('canonical', $items[0]->currentStatus());
        self::assertSame('connected', $items[0]->targetStatus());
        self::assertSame('promote_candidate', $items[0]->gateStatus());
        self::assertSame(65, $items[0]->score());
        self::assertNotEmpty($items[0]->requiredEvidence());
        self::assertNotEmpty($items[0]->blockingIssues());
        self::assertNotEmpty($items[0]->nextActions());
    }

    public function testItCountsPromotionGateStatus(): void
    {
        $provider = new EcommercePromotionGateProvider(new class implements EcommerceRuntimeBridgeProviderInterface {
            public function provide(): array
            {
                return [
                    $this->bridge('connected', 'ready'),
                    $this->bridge('canonical', 'needs_bridge'),
                    $this->bridge('planned', 'planned'),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Platform operations' => $this->provide()];
            }

            public function gradeCounts(): array
            {
                return ['ready' => 1, 'needs_bridge' => 1, 'planned' => 1, 'total' => 3];
            }

            private function bridge(string $status, string $grade): EcommerceRuntimeBridgeItem
            {
                return new EcommerceRuntimeBridgeItem(
                    id: $status.'.runtime-bridge',
                    zone: 'Platform operations',
                    component: ucfirst($status),
                    status: $status,
                    bridgeGrade: $grade,
                    primaryUrl: '/'.$status.'/',
                    routeBridge: ['route'],
                    controllerBridge: ['controller'],
                    queryBridge: ['query'],
                    commandBridge: ['command'],
                    policyBridge: ['policy'],
                    evidenceBridge: ['evidence'],
                    promotionGate: 'gate',
                    note: 'note',
                );
            }
        });

        self::assertSame(['blocked' => 1, 'promote_candidate' => 1, 'connected' => 1, 'total' => 3], $provider->gateCounts());
    }
}
