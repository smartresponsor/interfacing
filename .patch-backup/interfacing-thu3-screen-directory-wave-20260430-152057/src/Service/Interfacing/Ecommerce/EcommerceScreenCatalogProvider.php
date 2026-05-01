<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\CrudResourceLinkSetInterface;
use App\Interfacing\Contract\View\EcommerceScreenEntry;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;

final readonly class EcommerceScreenCatalogProvider implements EcommerceScreenCatalogProviderInterface
{
    public function __construct(private CrudResourceExplorerProviderInterface $crudResourceExplorerProvider)
    {
    }

    public function provide(): array
    {
        $entries = $this->platformEntries();

        foreach ($this->crudResourceExplorerProvider->provide() as $resource) {
            if (!$resource instanceof CrudResourceLinkSetInterface) {
                continue;
            }

            foreach ($this->crudOperationEntries($resource) as $entry) {
                $entries[] = $entry;
            }
        }

        usort(
            $entries,
            static fn (EcommerceScreenEntry $left, EcommerceScreenEntry $right): int => [
                self::zoneOrder($left->zone()),
                $left->zone(),
                $left->component(),
                $left->label(),
                self::operationOrder($left->operation()),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                $right->zone(),
                $right->component(),
                $right->label(),
                self::operationOrder($right->operation()),
                $right->id(),
            ],
        );

        return $entries;
    }

    public function groupedByZone(): array
    {
        $grouped = [];
        foreach ($this->provide() as $entry) {
            $grouped[$entry->zone()][] = $entry;
        }

        return $grouped;
    }

    public function statusCounts(): array
    {
        $counts = [
            'connected' => 0,
            'canonical' => 0,
            'planned' => 0,
        ];

        foreach ($this->provide() as $entry) {
            $counts[$entry->status()] = ($counts[$entry->status()] ?? 0) + 1;
        }

        return $counts;
    }

    /** @return list<EcommerceScreenEntry> */
    private function platformEntries(): array
    {
        return [
            new EcommerceScreenEntry('platform.workspace', 'Platform', 'Interfacing', 'Workspace dashboard', 'index', '/interfacing', 'connected', 'screen', 'Canonical shell dashboard; no business demo data.'),
            new EcommerceScreenEntry('platform.crud-explorer', 'Platform', 'Interfacing', 'CRUD Explorer', 'index', '/interfacing/crud/explorer', 'connected', 'screen', 'Canonical index of CRUD route grammar across Smart Responsor.'),
            new EcommerceScreenEntry('platform.doctor', 'Platform', 'Interfacing', 'Doctor', 'index', '/interfacing/interfacing-doctor', 'connected', 'screen', 'Operator diagnostics surface.'),
            new EcommerceScreenEntry('platform.health', 'Platform', 'Interfacing', 'Health', 'index', '/interfacing/health', 'connected', 'screen', 'Health and smoke surface.'),
            new EcommerceScreenEntry('messaging.notifications.inbox', 'Messaging', 'Messaging', 'Notifications inbox', 'index', '/interfacing/message.notifications.inbox', 'connected', 'screen', 'Connected screen; records must come from Messaging, not Interfacing.'),
            new EcommerceScreenEntry('messaging.rooms.collection', 'Messaging', 'Messaging', 'Rooms collection', 'index', '/interfacing/message.rooms.collection', 'connected', 'screen', 'Connected screen; Interfacing owns only rendering contract.'),
            new EcommerceScreenEntry('messaging.search.results', 'Messaging', 'Messaging', 'Search results', 'index', '/interfacing/message.search.results', 'connected', 'screen', 'Connected screen; Interfacing owns only rendering contract.'),
            new EcommerceScreenEntry('billing.meter.screen', 'Billing and paying', 'Billing', 'Billing meter', 'index', '/interfacing/billing/meter', 'connected', 'screen', 'Connected workbench screen.'),
            new EcommerceScreenEntry('ordering.summary.screen', 'Ordering', 'Ordering', 'Order summary', 'index', '/interfacing/order/summary', 'connected', 'screen', 'Connected workbench screen.'),
        ];
    }

    /** @return list<EcommerceScreenEntry> */
    private function crudOperationEntries(CrudResourceLinkSetInterface $resource): array
    {
        $zone = $this->zoneForComponent($resource->component());
        $baseId = 'crud.'.$resource->id();
        $label = $resource->label();
        $component = $resource->component();
        $status = $resource->status();

        return [
            new EcommerceScreenEntry($baseId.'.index', $zone, $component, $label, 'index', $resource->indexUrl(), $status, 'crud', $resource->note()),
            new EcommerceScreenEntry($baseId.'.new', $zone, $component, $label, 'new', $resource->newUrl(), $status, 'crud', 'New form route follows the canonical CRUD bridge.'),
            new EcommerceScreenEntry($baseId.'.show', $zone, $component, $label, 'show', $resource->showSampleUrl(), $status, 'crud-sample', 'Sample identifier is intentional; real id/slug comes from the owning component.'),
            new EcommerceScreenEntry($baseId.'.edit', $zone, $component, $label, 'edit', $resource->editSampleUrl(), $status, 'crud-sample', 'Sample identifier is intentional; real id/slug comes from the owning component.'),
            new EcommerceScreenEntry($baseId.'.delete', $zone, $component, $label, 'delete', $resource->deleteSampleUrl(), $status, 'crud-sample', 'Sample identifier is intentional; real id/slug comes from the owning component.'),
        ];
    }

    private function zoneForComponent(string $component): string
    {
        return match ($component) {
            'Accessing' => 'Access',
            'Cataloging', 'Faceting', 'Tagging', 'Search', 'Indexing' => 'Catalog and discovery',
            'Commercializing', 'Retailing' => 'Commercial and retail',
            'Ordering' => 'Ordering',
            'Billing', 'Paying' => 'Billing and paying',
            'Taxating', 'Complying', 'Governancing', 'Adjudicating' => 'Tax and governance',
            'Shipping', 'Addressing', 'Locating' => 'Fulfillment and location',
            'Messaging' => 'Messaging',
            'Documenting', 'Attaching' => 'Documents and attachments',
            'Bridging', 'Harvesting', 'Applicating', 'Runtiming', 'Rolling', 'Projecting' => 'Platform operations',
            default => 'Supporting components',
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

    private static function operationOrder(string $operation): int
    {
        return match ($operation) {
            'index' => 10,
            'new' => 20,
            'show' => 30,
            'edit' => 40,
            'delete' => 50,
            default => 900,
        };
    }
}
