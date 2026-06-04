<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommercePromotionGateItem;
use App\Interfacing\Contract\View\InterfaceEcommerceRuntimeHandoffItem;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommercePromotionGateProviderInterface;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommerceRuntimeHandoffProviderInterface;

final readonly class InterfaceEcommercePromotionGateProvider implements InterfaceEcommercePromotionGateProviderInterface
{
    public function __construct(private InterfaceEcommerceRuntimeHandoffProviderInterface $runtimeHandoffProvider)
    {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $items = [];
        foreach ($this->runtimeHandoffProvider->provide() as $handoff) {
            if (!$handoff instanceof InterfaceEcommerceRuntimeHandoffItem) {
                continue;
            }

            $items[] = new InterfaceEcommercePromotionGateItem(
                id: $handoff->id().'.promotion-gate',
                zone: $handoff->zone(),
                component: $handoff->component(),
                currentStatus: $handoff->status(),
                targetStatus: $this->targetStatus($handoff),
                gateStatus: $this->gateStatus($handoff),
                score: $this->score($handoff),
                primaryUrl: $handoff->primaryUrl(),
                requiredEvidence: $this->requiredEvidence($handoff),
                blockingIssues: $this->blockingIssues($handoff),
                nextActions: $this->nextActions($handoff),
                note: $handoff->note(),
            );
        }

        usort(
            $items,
            static fn (InterfaceEcommercePromotionGateItem $left, InterfaceEcommercePromotionGateItem $right): int => [
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

        return $cache = $items;
    }

    public function groupedByZone(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $grouped = [];
        foreach ($this->provide() as $item) {
            $grouped[$item->zone()][] = $item;
        }

        return $cache = $grouped;
    }

    public function gateCounts(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $counts = ['blocked' => 0, 'promote_candidate' => 0, 'connected' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            if (array_key_exists($item->gateStatus(), $counts)) {
                ++$counts[$item->gateStatus()];
            }
        }

        return $cache = $counts;
    }

    private function targetStatus(InterfaceEcommerceRuntimeHandoffItem $handoff): string
    {
        return match ($handoff->status()) {
            'connected' => 'connected',
            'canonical' => 'connected',
            default => 'canonical',
        };
    }

    private function gateStatus(InterfaceEcommerceRuntimeHandoffItem $handoff): string
    {
        return match ($handoff->handoffGrade()) {
            'ready' => 'connected',
            'needs_handoff' => 'promote_candidate',
            default => 'blocked',
        };
    }

    private function score(InterfaceEcommerceRuntimeHandoffItem $handoff): int
    {
        return match ($handoff->handoffGrade()) {
            'ready' => 100,
            'needs_handoff' => 65,
            default => 25,
        };
    }

    /** @return list<string> */
    private function requiredEvidence(InterfaceEcommerceRuntimeHandoffItem $handoff): array
    {
        return match ($handoff->handoffGrade()) {
            'ready' => [
                'current smoke proof for index/new/show/edit/delete routes',
                'component-owned fixture/provider proof for records and identifiers',
                'audit evidence for create/update/delete command paths',
            ],
            'needs_handoff' => [
                'host route handoff resolving canonical CRUD grammar',
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
    private function blockingIssues(InterfaceEcommerceRuntimeHandoffItem $handoff): array
    {
        return match ($handoff->handoffGrade()) {
            'ready' => ['no promotion blocker; keep runtime proof fresh before adding more actions'],
            'needs_handoff' => [
                'component is visible in Interfacing but not yet proven as connected runtime surface',
                'sample identifiers must be replaced by component identifiers before live promotion',
            ],
            default => [
                'resource is still planned; no fake Interfacing data rows are allowed',
                'route/controller/query/command handoffs are not yet defined',
            ],
        };
    }

    /** @return list<string> */
    private function nextActions(InterfaceEcommerceRuntimeHandoffItem $handoff): array
    {
        return match ($handoff->handoffGrade()) {
            'ready' => [
                'keep this component in connected status',
                'extend advanced actions only after preserving the same evidence contract',
            ],
            'needs_handoff' => [
                'wire host route and controller handoff for the primary CRUD resource',
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
