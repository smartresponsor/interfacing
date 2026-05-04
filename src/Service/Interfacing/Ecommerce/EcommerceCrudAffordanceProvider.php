<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceAdminTableRow;
use App\Interfacing\Contract\View\EcommerceCrudAffordance;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceAdminTableProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudAffordanceProviderInterface;

final readonly class EcommerceCrudAffordanceProvider implements EcommerceCrudAffordanceProviderInterface
{
    public function __construct(private EcommerceAdminTableProviderInterface $adminTableProvider)
    {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $affordances = [];

        foreach ($this->adminTableProvider->provide() as $row) {
            if (!$row instanceof EcommerceAdminTableRow) {
                continue;
            }

            $affordances[] = $this->filterAffordance($row);
            $affordances[] = $this->sortAffordance($row);
            $affordances[] = $this->bulkAffordance($row);
        }

        return $cache = $affordances;
    }

    public function groupedByZone(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $grouped = [];
        foreach ($this->provide() as $affordance) {
            $grouped[$affordance->zone()][] = $affordance;
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

        foreach ($this->provide() as $affordance) {
            ++$counts['total'];
            if (array_key_exists($affordance->status(), $counts)) {
                ++$counts[$affordance->status()];
            }
        }

        return $cache = $counts;
    }

    private function filterAffordance(EcommerceAdminTableRow $row): EcommerceCrudAffordance
    {
        return new EcommerceCrudAffordance(
            id: $row->id().'.filter.affordance',
            zone: $row->zone(),
            component: $row->component(),
            resourceLabel: $row->resourceLabel(),
            status: $row->status(),
            type: 'filter-search',
            title: $row->resourceLabel().' filters and search',
            primaryUrl: $row->indexUrl().'?q=',
            secondaryUrl: $row->indexUrl(),
            contractTitle: 'Index filters are component-owned',
            contractText: sprintf('%s provides searchable fields, filter operators, query DTOs and fixture-backed result rows. Interfacing renders only the toolbar affordance and route-transparent shell.', $row->component()),
            routePattern: '/{resource}/?q={query}&filter[{field}]={value}',
            badge: 'Search + filters',
            note: $row->note(),
        );
    }

    private function sortAffordance(EcommerceAdminTableRow $row): EcommerceCrudAffordance
    {
        return new EcommerceCrudAffordance(
            id: $row->id().'.sort.affordance',
            zone: $row->zone(),
            component: $row->component(),
            resourceLabel: $row->resourceLabel(),
            status: $row->status(),
            type: 'sort-pagination',
            title: $row->resourceLabel().' sort and pagination',
            primaryUrl: $row->indexUrl().'?sort=id&direction=asc&page=1',
            secondaryUrl: $row->indexUrl(),
            contractTitle: 'Sorting is declared by the owning component',
            contractText: sprintf('%s owns allowed sort fields, default ordering, pagination limits and total-count semantics. Interfacing renders the index toolbar contract only.', $row->component()),
            routePattern: '/{resource}/?sort={field}&direction={asc|desc}&page={page}',
            badge: 'Sort + paging',
            note: $row->note(),
        );
    }

    private function bulkAffordance(EcommerceAdminTableRow $row): EcommerceCrudAffordance
    {
        return new EcommerceCrudAffordance(
            id: $row->id().'.bulk.affordance',
            zone: $row->zone(),
            component: $row->component(),
            resourceLabel: $row->resourceLabel(),
            status: $row->status(),
            type: 'bulk-actions',
            title: $row->resourceLabel().' bulk actions',
            primaryUrl: $row->indexUrl().'#bulk-actions',
            secondaryUrl: $row->deleteUrl(),
            contractTitle: 'Bulk behavior needs component policy',
            contractText: sprintf('%s owns selectable identifiers, authorization, destructive confirmations, audit evidence and transaction policy. Interfacing renders the bulk-action affordance without inventing records.', $row->component()),
            routePattern: '/{resource}/ + selected ids + component operation handler',
            badge: 'Bulk actions',
            note: $row->note(),
        );
    }
}
