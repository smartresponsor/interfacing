<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Contract\View\EcommercePromotionGateItem;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceEvidenceRegistryProvider;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommercePromotionGateProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceEvidenceRegistryProviderTest extends TestCase
{
    public function testItBuildsEvidenceItemsFromPromotionGates(): void
    {
        $provider = new EcommerceEvidenceRegistryProvider(new class implements EcommercePromotionGateProviderInterface {
            public function provide(): array
            {
                return [
                    new EcommercePromotionGateItem(
                        id: 'cataloging.promotion-gate',
                        zone: 'Catalog and discovery',
                        component: 'Cataloging',
                        currentStatus: 'canonical',
                        targetStatus: 'connected',
                        gateStatus: 'promote_candidate',
                        score: 65,
                        primaryUrl: '/product/',
                        requiredEvidence: ['host route proof'],
                        blockingIssues: ['command bridge missing'],
                        nextActions: ['wire command bridge'],
                        note: 'Cataloging promotion gate.',
                    ),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Catalog and discovery' => $this->provide()];
            }

            public function gateCounts(): array
            {
                return ['blocked' => 0, 'promote_candidate' => 1, 'connected' => 0, 'total' => 1];
            }
        });

        $items = $provider->provide();

        self::assertCount(1, $items);
        self::assertSame('Cataloging', $items[0]->component());
        self::assertSame('partial', $items[0]->evidenceGrade());
        self::assertSame(60, $items[0]->score());
        self::assertNotEmpty($items[0]->routeEvidence());
        self::assertNotEmpty($items[0]->dataEvidence());
        self::assertNotEmpty($items[0]->operationEvidence());
        self::assertNotEmpty($items[0]->policyEvidence());
        self::assertNotEmpty($items[0]->auditEvidence());
        self::assertNotEmpty($items[0]->missingEvidence());
    }

    public function testItCountsEvidenceGrades(): void
    {
        $provider = new EcommerceEvidenceRegistryProvider(new class implements EcommercePromotionGateProviderInterface {
            public function provide(): array
            {
                return [
                    $this->gate('planned', 'canonical', 'blocked'),
                    $this->gate('canonical', 'connected', 'promote_candidate'),
                    $this->gate('connected', 'connected', 'connected'),
                ];
            }

            public function groupedByZone(): array
            {
                return ['Platform operations' => $this->provide()];
            }

            public function gateCounts(): array
            {
                return ['blocked' => 1, 'promote_candidate' => 1, 'connected' => 1, 'total' => 3];
            }

            private function gate(string $current, string $target, string $gateStatus): EcommercePromotionGateItem
            {
                return new EcommercePromotionGateItem(
                    id: $current.'.promotion-gate',
                    zone: 'Platform operations',
                    component: ucfirst($current),
                    currentStatus: $current,
                    targetStatus: $target,
                    gateStatus: $gateStatus,
                    score: 10,
                    primaryUrl: '/'.$current.'/',
                    requiredEvidence: ['evidence'],
                    blockingIssues: ['blocker'],
                    nextActions: ['action'],
                    note: 'note',
                );
            }
        });

        self::assertSame(['complete' => 1, 'partial' => 1, 'missing' => 1, 'total' => 3], $provider->gradeCounts());
    }
}
