<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceOperationCard;
use App\Interfacing\Contract\View\EcommerceScreenEntry;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceOperationWorkbenchProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;

final readonly class EcommerceOperationWorkbenchProvider implements EcommerceOperationWorkbenchProviderInterface
{
    public function __construct(private EcommerceScreenCatalogProviderInterface $screenCatalogProvider)
    {
    }

    public function provide(): array
    {
        $buckets = [];

        foreach ($this->screenCatalogProvider->provide() as $entry) {
            if (!$entry instanceof EcommerceScreenEntry || !str_starts_with($entry->id(), 'crud.')) {
                continue;
            }

            $resourceKey = $this->resourceKey($entry->id());
            $buckets[$resourceKey] ??= [
                'zone' => $entry->zone(),
                'component' => $entry->component(),
                'label' => $entry->label(),
                'status' => $entry->status(),
                'note' => null,
                'action' => [],
            ];

            $buckets[$resourceKey]['action'][$entry->operation()] = $entry;
            $buckets[$resourceKey]['status'] = $this->strongerStatus($buckets[$resourceKey]['status'], $entry->status());
            $buckets[$resourceKey]['note'] ??= $entry->note();
        }

        $cards = [];
        foreach ($buckets as $key => $bucket) {
            /** @var array<string, EcommerceScreenEntry> $action */
            $action = $bucket['action'];
            if (!isset($action['index'], $action['new'], $action['show'], $action['edit'], $action['delete'])) {
                continue;
            }

            $cards[] = new EcommerceOperationCard(
                id: $key,
                zone: $bucket['zone'],
                component: $bucket['component'],
                label: $bucket['label'],
                resourceStatus: $bucket['status'],
                indexUrl: $action['index']->url(),
                newUrl: $action['new']->url(),
                showUrl: $action['show']->url(),
                editUrl: $action['edit']->url(),
                deleteUrl: $action['delete']->url(),
                resourceKind: 'crud-resource',
                note: $bucket['note'],
                action: [$action['index'], $action['new'], $action['show'], $action['edit'], $action['delete']],
            );
        }

        usort(
            $cards,
            static fn (EcommerceOperationCard $left, EcommerceOperationCard $right): int => [
                self::zoneOrder($left->zone()),
                $left->zone(),
                $left->component(),
                $left->label(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                $right->zone(),
                $right->component(),
                $right->label(),
                $right->id(),
            ],
        );

        return $cards;
    }

    public function groupedByZone(): array
    {
        $grouped = [];
        foreach ($this->provide() as $card) {
            $grouped[$card->zone()][] = $card;
        }

        return $grouped;
    }

    public function statusCounts(): array
    {
        $counts = ['connected' => 0, 'canonical' => 0, 'planned' => 0, 'total' => 0];

        foreach ($this->provide() as $card) {
            ++$counts['total'];
            ++$counts[$card->resourceStatus()];
        }

        return $counts;
    }

    private function resourceKey(string $entryId): string
    {
        $parts = explode('.', $entryId);
        array_pop($parts);

        return implode('.', $parts);
    }

    private function strongerStatus(string $left, string $right): string
    {
        return self::statusWeight($right) < self::statusWeight($left) ? $right : $left;
    }

    private static function statusWeight(string $status): int
    {
        return match ($status) {
            'connected' => 10,
            'canonical' => 20,
            'planned' => 30,
            default => 900,
        };
    }

    private static function zoneOrder(string $zone): int
    {
        return match ($zone) {
            'Platform' => 10,
            'Access' => 20,
            'Catalog and discovery' => 30,
            'Commercial and retail' => 40,
            'Ordering' => 50,
            'Billing and paying' => 60,
            'Tax and governance' => 70,
            'Fulfillment and location' => 80,
            'Messaging' => 90,
            'Documents and attachments' => 100,
            'Platform operations' => 110,
            default => 900,
        };
    }
}
