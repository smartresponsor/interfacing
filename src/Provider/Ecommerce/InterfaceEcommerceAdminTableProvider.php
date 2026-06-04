<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Ecommerce;

use App\Interfacing\Contract\View\InterfaceEcommerceAdminTableRow;
use App\Interfacing\Contract\View\InterfaceEcommerceOperationCard;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommerceAdminTableProviderInterface;
use App\Interfacing\ProviderInterface\Ecommerce\InterfaceEcommerceOperationWorkbenchProviderInterface;

final readonly class InterfaceEcommerceAdminTableProvider implements InterfaceEcommerceAdminTableProviderInterface
{
    public function __construct(private InterfaceEcommerceOperationWorkbenchProviderInterface $operationWorkbenchProvider)
    {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $rows = [];

        foreach ($this->operationWorkbenchProvider->provide() as $card) {
            if (!$card instanceof InterfaceEcommerceOperationCard) {
                continue;
            }

            $rows[] = new InterfaceEcommerceAdminTableRow(
                id: $card->id(),
                zone: $card->zone(),
                component: $card->component(),
                resourceLabel: $card->label(),
                status: $card->resourceStatus(),
                indexUrl: $card->indexUrl(),
                newUrl: $card->newUrl(),
                showUrl: $card->showUrl(),
                editUrl: $card->editUrl(),
                deleteUrl: $card->deleteUrl(),
                identifierPreview: $this->identifierPreview($card),
                emptyStateTitle: $card->label().' records are not provided by Interfacing',
                emptyStateText: $this->emptyStateText($card),
                note: $card->note(),
            );
        }

        return $cache = $rows;
    }

    public function groupedByZone(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $grouped = [];
        foreach ($this->provide() as $row) {
            $grouped[$row->zone()][] = $row;
        }

        return $cache = $grouped;
    }

    public function statusCounts(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $counts = ['connected' => 0, 'canonical' => 0, 'planned' => 0, 'total' => 0];

        foreach ($this->provide() as $row) {
            ++$counts['total'];
            if (array_key_exists($row->status(), $counts)) {
                ++$counts[$row->status()];
            }
        }

        return $cache = $counts;
    }

    private function identifierPreview(InterfaceEcommerceOperationCard $card): string
    {
        foreach ([$card->showUrl(), $card->editUrl(), $card->deleteUrl()] as $url) {
            if (str_contains($url, 'sample')) {
                return 'sample';
            }
            if (str_contains($url, 'demo')) {
                return 'demo';
            }
        }

        return '{id}';
    }

    private function emptyStateText(InterfaceEcommerceOperationCard $card): string
    {
        return sprintf(
            '%s owns fixtures, records and identifiers. Interfacing renders only the table shell, empty state and action affordances for the canonical %s CRUD route family.',
            $card->component(),
            $card->label(),
        );
    }
}
