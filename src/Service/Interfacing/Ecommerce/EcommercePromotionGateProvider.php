<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommercePromotionGateItem;
use App\Interfacing\Contract\View\EcommerceRuntimeBridgeItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommercePromotionGateProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceRuntimeBridgeProviderInterface;

final readonly class EcommercePromotionGateProvider implements EcommercePromotionGateProviderInterface
{
    public function __construct(private EcommerceRuntimeBridgeProviderInterface $runtimeBridgeProvider)
    {
    }

    public function provide(): array
    {
        $items = [];
        foreach ($this->runtimeBridgeProvider->provide() as $bridge) {
            if (!$bridge instanceof EcommerceRuntimeBridgeItem) {
                continue;
            }

            $items[] = new EcommercePromotionGateItem(
                id: $bridge->id().'.promotion-gate',
                zone: $bridge->zone(),
                component: $bridge->component(),
                currentStatus: $bridge->status(),
                targetStatus: $this->targetStatus($bridge),
                gateStatus: $this->gateStatus($bridge),
                score: $this->score($bridge),
                primaryUrl: $bridge->primaryUrl(),
                requiredEvidence: $this->requiredEvidence($bridge),
                blockingIssues: $this->blockingIssues($bridge),
                nextActions: $this->nextActions($bridge),
                note: $bridge->note(),
            );
        }

        usort(
            $items,
            static fn (EcommercePromotionGateItem $left, EcommercePromotionGateItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gateOrder($left->gateStatus()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gateOrder($right->gateStatus()),
                $right->component(),
                $right->id(),
            ],
        );

        return $items;
    }

    public function groupedByZone(): array
    {
        $grouped = [];
        foreach ($this->provide() as $item) {
            $grouped[$item->zone()][] = $item;
        }

        return $grouped;
    }

    public function gateCounts(): array
    {
        $counts = ['blocked' => 0, 'promote_candidate' => 0, 'connected' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            if (array_key_exists($item->gateStatus(), $counts)) {
                ++$counts[$item->gateStatus()];
            }
        }

        return $counts;
    }

    private function targetStatus(EcommerceRuntimeBridgeItem $bridge): string
    {
        return match ($bridge->status()) {
            'connected' => 'connected',
            'canonical' => 'connected',
            default => 'canonical',
        };
    }

    private function gateStatus(EcommerceRuntimeBridgeItem $bridge): string
    {
        return match ($bridge->bridgeGrade()) {
            'ready' => 'connected',
            'needs_bridge' => 'promote_candidate',
            default => 'blocked',
        };
    }

    private function score(EcommerceRuntimeBridgeItem $bridge): int
    {
        return match ($bridge->bridgeGrade()) {
            'ready' => 100,
            'needs_bridge' => 65,
            default => 25,
        };
    }

    /** @return list<string> */
    private function requiredEvidence(EcommerceRuntimeBridgeItem $bridge): array
    {
        return match ($bridge->bridgeGrade()) {
            'ready' => [
                'current smoke proof for index/new/show/edit/delete routes',
                'component-owned fixture/provider proof for records and identifiers',
                'audit evidence for create/update/delete command paths',
            ],
            'needs_bridge' => [
                'host route bridge resolving canonical CRUD grammar',
                'controller/query/command contract wired to the owning component',
                'authorization and destructive-action policy proof',
            ],
            default => [
                'canonical resource contract and route path decision',
                'component-owned fixture/provider plan',
                'promotion issue linking planned resources to owner implementation work',
            ],
        };
    }

    /** @return list<string> */
    private function blockingIssues(EcommerceRuntimeBridgeItem $bridge): array
    {
        return match ($bridge->bridgeGrade()) {
            'ready' => ['no promotion blocker; keep runtime proof fresh before adding more actions'],
            'needs_bridge' => [
                'component is visible in Interfacing but not yet proven as connected runtime surface',
                'sample identifiers must be replaced by component identifiers before live promotion',
            ],
            default => [
                'resource is still planned; no fake Interfacing data rows are allowed',
                'route/controller/query/command bridges are not yet defined',
            ],
        };
    }

    /** @return list<string> */
    private function nextActions(EcommerceRuntimeBridgeItem $bridge): array
    {
        return match ($bridge->bridgeGrade()) {
            'ready' => [
                'keep this component in connected status',
                'extend advanced actions only after preserving the same evidence contract',
            ],
            'needs_bridge' => [
                'wire host route and controller bridge for the primary CRUD resource',
                'prove query and command handlers against component-owned fixtures',
                'update component status from canonical to connected after smoke proof',
            ],
            default => [
                'promote planned component to canonical only after resource names and CRUD paths are approved',
                'do not add temporary business rows inside Interfacing',
            ],
        };
    }

    private static function zoneOrder(string $zone): int
    {
        return match ($zone) {
            'Access' => 10,
            'Catalog and discovery' => 20,
            'Commercial and retail' => 30,
            'Ordering' => 40,
            'Billing and paying' => 50,
            'Tax and governance' => 60,
            'Fulfillment and location' => 70,
            'Messaging' => 80,
            'Documents and attachments' => 90,
            'Platform operations' => 100,
            default => 900,
        };
    }

    private static function gateOrder(string $gateStatus): int
    {
        return match ($gateStatus) {
            'blocked' => 10,
            'promote_candidate' => 20,
            'connected' => 30,
            default => 900,
        };
    }
}
