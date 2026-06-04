<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceComponentRoadmapItem;
use App\Interfacing\Contract\View\InterfaceEcommerceRuntimeHandoffItem;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommerceComponentRoadmapProviderInterface;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommerceRuntimeHandoffProviderInterface;

final readonly class InterfaceEcommerceRuntimeHandoffProvider implements InterfaceEcommerceRuntimeHandoffProviderInterface
{
    public function __construct(private InterfaceEcommerceComponentRoadmapProviderInterface $roadmapProvider)
    {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $items = [];

        foreach ($this->roadmapProvider->provide() as $roadmap) {
            if (!$roadmap instanceof InterfaceEcommerceComponentRoadmapItem) {
                continue;
            }

            $items[] = new InterfaceEcommerceRuntimeHandoffItem(
                id: $roadmap->id().'.runtime-handoff',
                zone: $roadmap->zone(),
                component: $roadmap->component(),
                status: $roadmap->status(),
                handoffGrade: $this->handoffGrade($roadmap->status()),
                primaryUrl: $roadmap->primaryUrl(),
                routeHandoff: $this->routeHandoff($roadmap),
                controllerHandoff: $this->controllerHandoff($roadmap),
                queryHandoff: $this->queryHandoff($roadmap),
                commandHandoff: $this->commandHandoff($roadmap),
                policyHandoff: $this->policyHandoff($roadmap),
                evidenceHandoff: $this->evidenceHandoff($roadmap),
                promotionGate: $this->promotionGate($roadmap),
                note: $roadmap->note(),
            );
        }

        usort(
            $items,
            static fn (InterfaceEcommerceRuntimeHandoffItem $left, InterfaceEcommerceRuntimeHandoffItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gradeOrder($left->handoffGrade()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gradeOrder($right->handoffGrade()),
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

        $counts = ['ready' => 0, 'needs_handoff' => 0, 'planned' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            if (array_key_exists($item->handoffGrade(), $counts)) {
                ++$counts[$item->handoffGrade()];
            }
        }

        return $cache = $counts;
    }

    private function handoffGrade(string $status): string
    {
        return match ($status) {
            'connected' => 'ready',
            'canonical' => 'needs_handoff',
            default => 'planned',
        };
    }

    /** @return list<string> */
    private function routeHandoff(InterfaceEcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'publish host routes for every required CRUD resource using canonical grammar',
            'keep index/new/show/edit/delete route semantics stable across host applications',
            sprintf('promote %s to connected only after host routes resolve without placeholder fallbacks', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function controllerHandoff(InterfaceEcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'owning component provides controller or adapter endpoint for index/show/new/edit/delete frames',
            'controller returns component-owned data contract, not Interfacing demo rows',
            sprintf('%s keeps its controller namespace and persistence concerns outside Interfacing', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function queryHandoff(InterfaceEcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'index query supports columns, filters, search, sort and pagination metadata',
            'show query resolves a real component identifier or slug',
            'empty states are returned as contract state, not as fake records',
        ];
    }

    /** @return list<string> */
    private function commandHandoff(InterfaceEcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'new/edit command handler owns validation, persistence and failure reporting',
            'delete command handler owns confirmation, authorization and audit emission',
            'bulk actions are exposed only when the component has idempotent handlers',
        ];
    }

    /** @return list<string> */
    private function policyHandoff(InterfaceEcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'route access and button visibility are permission-aware',
            'destructive actions require component policy confirmation before execution',
            sprintf('%s owns policy names and role mapping; Interfacing renders disabled/forbidden states', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function evidenceHandoff(InterfaceEcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'runtime smoke proof against component-owned fixtures/providers',
            'audit trail proof for create/update/delete commands',
            'documentation evidence that sample identifiers were replaced by component identifiers',
        ];
    }

    private function promotionGate(InterfaceEcommerceComponentRoadmapItem $roadmap): string
    {
        return match ($roadmap->status()) {
            'connected' => 'Keep route/controller/query/command handoff smoke proof current before extending actions.',
            'canonical' => 'Add host route + controller/query/command handoff before marking this component connected.',
            default => 'Define route/resource contract first; planned resources must not gain fake Interfacing data rows.',
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
            'planned' => 10,
            'needs_handoff' => 20,
            'ready' => 30,
            default => 900,
        };
    }
}
