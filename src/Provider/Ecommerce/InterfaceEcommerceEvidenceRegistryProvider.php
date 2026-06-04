<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceEvidenceItem;
use App\Interfacing\Contract\View\InterfaceEcommercePromotionGateItem;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommerceEvidenceRegistryProviderInterface;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommercePromotionGateProviderInterface;

final readonly class InterfaceEcommerceEvidenceRegistryProvider implements InterfaceEcommerceEvidenceRegistryProviderInterface
{
    public function __construct(private InterfaceEcommercePromotionGateProviderInterface $promotionGateProvider)
    {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $items = [];
        foreach ($this->promotionGateProvider->provide() as $gate) {
            if (!$gate instanceof InterfaceEcommercePromotionGateItem) {
                continue;
            }
            $items[] = new InterfaceEcommerceEvidenceItem(
                id: $gate->id().'.evidence',
                zone: $gate->zone(),
                component: $gate->component(),
                status: $gate->currentStatus(),
                evidenceGrade: $this->evidenceGrade($gate->gateStatus()),
                score: $this->score($gate->gateStatus()),
                primaryUrl: $gate->primaryUrl(),
                routeEvidence: $this->routeEvidence($gate),
                dataEvidence: $this->dataEvidence($gate),
                operationEvidence: $this->operationEvidence($gate),
                policyEvidence: $this->policyEvidence($gate),
                auditEvidence: $this->auditEvidence($gate),
                missingEvidence: $this->missingEvidence($gate),
                note: $gate->note(),
            );
        }

        usort(
            $items,
            static fn (InterfaceEcommerceEvidenceItem $left, InterfaceEcommerceEvidenceItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gradeOrder($left->evidenceGrade()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gradeOrder($right->evidenceGrade()),
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

    public function gradeCounts(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $counts = ['complete' => 0, 'partial' => 0, 'missing' => 0, 'total' => 0];
        foreach ($this->provide() as $item) {
            ++$counts['total'];
            ++$counts[$item->evidenceGrade()];
        }

        return $cache = $counts;
    }

    private function evidenceGrade(string $gateStatus): string
    {
        return match ($gateStatus) {
            'connected' => 'complete',
            'promote_candidate' => 'partial',
            default => 'missing',
        };
    }

    private function score(string $gateStatus): int
    {
        return match ($gateStatus) {
            'connected' => 100,
            'promote_candidate' => 60,
            default => 20,
        };
    }

    /** @return list<string> */
    private function routeEvidence(InterfaceEcommercePromotionGateItem $gate): array
    {
        return match ($gate->gateStatus()) {
            'connected' => ['host route resolves canonical CRUD grammar', 'index/new/show/edit/delete paths have smoke proof'],
            'promote_candidate' => ['canonical CRUD paths are known', 'host route/controller wiring is the next proof item'],
            default => ['resource path decision required before route proof'],
        };
    }

    /** @return list<string> */
    private function dataEvidence(InterfaceEcommercePromotionGateItem $gate): array
    {
        return match ($gate->gateStatus()) {
            'connected' => ['component-owned fixtures/providers provide records and identifiers', 'sample identifiers are no longer used as business data'],
            'promote_candidate' => ['component fixtures/providers must replace sample identifiers', 'field schema and identifiers must be published by owner component'],
            default => ['no Interfacing demo rows are allowed', 'owner component must define fixtures/provider plan'],
        };
    }

    /** @return list<string> */
    private function operationEvidence(InterfaceEcommercePromotionGateItem $gate): array
    {
        return match ($gate->gateStatus()) {
            'connected' => ['query and command handlers exist for live CRUD operations', 'empty/error states come from component contracts'],
            'promote_candidate' => ['query handoff exists or is ready to wire', 'command handoff for save/delete remains promotion blocker'],
            default => ['query/command contracts not yet proven'],
        };
    }

    /** @return list<string> */
    private function policyEvidence(InterfaceEcommercePromotionGateItem $gate): array
    {
        return match ($gate->gateStatus()) {
            'connected' => ['authorization and destructive-action guards are component-owned and proven'],
            'promote_candidate' => ['permission names and button visibility policy must be wired'],
            default => ['policy handoff must be planned before live delete/edit actions'],
        };
    }

    /** @return list<string> */
    private function auditEvidence(InterfaceEcommercePromotionGateItem $gate): array
    {
        return match ($gate->gateStatus()) {
            'connected' => ['create/update/delete actions emit audit evidence', 'runtime proof remains current after extending actions'],
            'promote_candidate' => ['audit event naming and destructive-action evidence remain required'],
            default => ['audit evidence is missing until owner component provides command handlers'],
        };
    }

    /** @return list<string> */
    private function missingEvidence(InterfaceEcommercePromotionGateItem $gate): array
    {
        return match ($gate->gateStatus()) {
            'connected' => ['none for basic promotion; keep smoke proof fresh'],
            'promote_candidate' => ['host runtime handoff smoke proof', 'component identifiers and form schema', 'authorization and audit proof'],
            default => ['canonical resource contract', 'component-owned fixture/provider plan', 'route/controller/query/command handoff plan'],
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

    private static function gradeOrder(string $grade): int
    {
        return match ($grade) {
            'missing' => 10,
            'partial' => 20,
            'complete' => 30,
            default => 900,
        };
    }
}
