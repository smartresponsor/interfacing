<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceComponentRoadmapItem;
use App\Interfacing\Contract\View\EcommerceRuntimeBridgeItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceRuntimeBridgeProviderInterface;

final readonly class EcommerceRuntimeBridgeProvider implements EcommerceRuntimeBridgeProviderInterface
{
    public function __construct(private EcommerceComponentRoadmapProviderInterface $roadmapProvider)
    {
    }

    public function provide(): array
    {
        $items = [];

        foreach ($this->roadmapProvider->provide() as $roadmap) {
            if (!$roadmap instanceof EcommerceComponentRoadmapItem) {
                continue;
            }

            $items[] = new EcommerceRuntimeBridgeItem(
                id: $roadmap->id().'.runtime-bridge',
                zone: $roadmap->zone(),
                component: $roadmap->component(),
                status: $roadmap->status(),
                bridgeGrade: $this->bridgeGrade($roadmap->status()),
                primaryUrl: $roadmap->primaryUrl(),
                routeBridge: $this->routeBridge($roadmap),
                controllerBridge: $this->controllerBridge($roadmap),
                queryBridge: $this->queryBridge($roadmap),
                commandBridge: $this->commandBridge($roadmap),
                policyBridge: $this->policyBridge($roadmap),
                evidenceBridge: $this->evidenceBridge($roadmap),
                promotionGate: $this->promotionGate($roadmap),
                note: $roadmap->note(),
            );
        }

        usort(
            $items,
            static fn (EcommerceRuntimeBridgeItem $left, EcommerceRuntimeBridgeItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gradeOrder($left->bridgeGrade()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gradeOrder($right->bridgeGrade()),
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

    public function gradeCounts(): array
    {
        $counts = ['ready' => 0, 'needs_bridge' => 0, 'planned' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            if (array_key_exists($item->bridgeGrade(), $counts)) {
                ++$counts[$item->bridgeGrade()];
            }
        }

        return $counts;
    }

    private function bridgeGrade(string $status): string
    {
        return match ($status) {
            'connected' => 'ready',
            'canonical' => 'needs_bridge',
            default => 'planned',
        };
    }

    /** @return list<string> */
    private function routeBridge(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'publish host routes for every required CRUD resource using canonical grammar',
            'keep index/new/show/edit/delete route semantics stable across host applications',
            sprintf('promote %s to connected only after host routes resolve without placeholder fallbacks', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function controllerBridge(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'owning component provides controller or adapter endpoint for index/show/new/edit/delete frames',
            'controller returns component-owned data contract, not Interfacing demo rows',
            sprintf('%s keeps its controller namespace and persistence concerns outside Interfacing', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function queryBridge(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'index query supports columns, filters, search, sort and pagination metadata',
            'show query resolves a real component identifier or slug',
            'empty states are returned as contract state, not as fake records',
        ];
    }

    /** @return list<string> */
    private function commandBridge(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'new/edit command handler owns validation, persistence and failure reporting',
            'delete command handler owns confirmation, authorization and audit emission',
            'bulk actions are exposed only when the component has idempotent handlers',
        ];
    }

    /** @return list<string> */
    private function policyBridge(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'route access and button visibility are permission-aware',
            'destructive actions require component policy confirmation before execution',
            sprintf('%s owns policy names and role mapping; Interfacing renders disabled/forbidden states', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function evidenceBridge(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'runtime smoke proof against component-owned fixtures/providers',
            'audit trail proof for create/update/delete commands',
            'documentation evidence that sample identifiers were replaced by component identifiers',
        ];
    }

    private function promotionGate(EcommerceComponentRoadmapItem $roadmap): string
    {
        return match ($roadmap->status()) {
            'connected' => 'Keep route/controller/query/command bridge smoke proof current before extending actions.',
            'canonical' => 'Add host route + controller/query/command bridge before marking this component connected.',
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
            'needs_bridge' => 20,
            'ready' => 30,
            default => 900,
        };
    }
}
