<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceComponentObligationItem;
use App\Interfacing\Contract\View\EcommerceComponentRoadmapItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentObligationProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;

final readonly class EcommerceComponentObligationProvider implements EcommerceComponentObligationProviderInterface
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

            $items[] = new EcommerceComponentObligationItem(
                id: $roadmap->id().'.obligations',
                zone: $roadmap->zone(),
                component: $roadmap->component(),
                status: $roadmap->status(),
                riskLevel: $this->riskLevel($roadmap->status()),
                primaryUrl: $roadmap->primaryUrl(),
                requiredScreens: $roadmap->screen(),
                requiredResources: $roadmap->resource(),
                fixtureObligations: $this->fixtureObligations($roadmap),
                contractObligations: $this->contractObligations($roadmap),
                runtimeObligations: $this->runtimeObligations($roadmap),
                evidenceObligations: $this->evidenceObligations($roadmap),
                boundary: sprintf('%s owns records, fixtures, identifiers, fields, validation, persistence, policies, handlers and audit evidence. Interfacing owns only shell, navigation, route-transparent frames and operator affordances.', $roadmap->component()),
                note: $roadmap->note(),
            );
        }

        usort(
            $items,
            static fn (EcommerceComponentObligationItem $left, EcommerceComponentObligationItem $right): int => [
                self::zoneOrder($left->zone()),
                self::riskOrder($left->riskLevel()),
                $left->component(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::riskOrder($right->riskLevel()),
                $right->component(),
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

    public function riskCounts(): array
    {
        $counts = ['high' => 0, 'medium' => 0, 'low' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            if (array_key_exists($item->riskLevel(), $counts)) {
                ++$counts[$item->riskLevel()];
            }
        }

        return $counts;
    }

    private function riskLevel(string $status): string
    {
        return match ($status) {
            'connected' => 'low',
            'canonical' => 'medium',
            default => 'high',
        };
    }

    /** @return list<string> */
    private function fixtureObligations(EcommerceComponentRoadmapItem $roadmap): array
    {
        return match ($roadmap->status()) {
            'connected' => ['component fixtures/providers remain the only source for records', 'sample identifiers must be replaceable with real component identifiers'],
            'canonical' => ['publish component fixtures/providers for host use', 'provide deterministic sample identifiers for smoke navigation'],
            default => ['define fixture/provider contract before host connection', 'do not model planned records inside Interfacing'],
        };
    }

    /** @return list<string> */
    private function contractObligations(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            sprintf('field schema for %s resources', $roadmap->component()),
            'index columns, filters, sort keys and pagination capability',
            'new/edit form fields, validation rules and read-only states',
            'show/detail vocabulary and row action labels',
        ];
    }

    /** @return list<string> */
    private function runtimeObligations(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'controller/bridge routes matching the canonical CRUD grammar',
            'query handlers for index/show and command handlers for save/delete',
            'authorization checks for every destructive or sensitive operation',
            sprintf('host wiring for %s routes before status is promoted to connected', $roadmap->component()),
        ];
    }

    /** @return list<string> */
    private function evidenceObligations(EcommerceComponentRoadmapItem $roadmap): array
    {
        return [
            'audit events for create/update/delete actions',
            'runtime smoke proof against component-owned fixtures',
            'permission proof for disabled/forbidden actions',
            sprintf('documentation proving %s owns data and Interfacing only renders UI frames', $roadmap->component()),
        ];
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

    private static function riskOrder(string $risk): int
    {
        return match ($risk) {
            'high' => 10,
            'medium' => 20,
            'low' => 30,
            default => 900,
        };
    }
}
