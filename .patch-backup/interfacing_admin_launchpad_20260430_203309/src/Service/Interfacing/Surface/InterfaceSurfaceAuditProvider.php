<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Surface;

use App\Interfacing\Contract\View\EcommerceScreenEntry;
use App\Interfacing\Contract\View\InterfaceSurfaceAuditItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Surface\InterfaceSurfaceAuditProviderInterface;

final readonly class InterfaceSurfaceAuditProvider implements InterfaceSurfaceAuditProviderInterface
{
    public function __construct(private EcommerceScreenCatalogProviderInterface $screenCatalogProvider)
    {
    }

    public function provide(): array
    {
        $items = array_merge(
            $this->shellItems(),
            $this->crudItems(),
            $this->dataBoundaryItems(),
            $this->componentCoverageItems(),
        );

        usort(
            $items,
            static fn (InterfaceSurfaceAuditItem $left, InterfaceSurfaceAuditItem $right): int => [
                self::areaOrder($left->area()),
                self::statusOrder($left->status()),
                $left->label(),
                $left->id(),
            ] <=> [
                self::areaOrder($right->area()),
                self::statusOrder($right->status()),
                $right->label(),
                $right->id(),
            ],
        );

        return $items;
    }

    public function groupedByArea(): array
    {
        $grouped = [];
        foreach ($this->provide() as $item) {
            $grouped[$item->area()][] = $item;
        }

        return $grouped;
    }

    public function statusCounts(): array
    {
        $counts = ['solid' => 0, 'watch' => 0, 'drift' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            ++$counts[$item->status()];
        }

        return $counts;
    }

    /** @return list<InterfaceSurfaceAuditItem> */
    private function shellItems(): array
    {
        return [
            new InterfaceSurfaceAuditItem('shell.workspace', 'Shell coverage', 'Workspace dashboard', 'solid', '/interfacing', 'Uses the canonical Interfacing base shell with topbar, left navigation, content area, and footer.'),
            new InterfaceSurfaceAuditItem('shell.launchpad', 'Shell coverage', 'Admin launchpad', 'solid', '/interfacing/launchpad', 'Shell-native launchpad for grouped e-commerce admin navigation without embedded business rows.'),
            new InterfaceSurfaceAuditItem('shell.screens', 'Shell coverage', 'Screen directory', 'solid', '/interfacing/screens', 'Shell-native directory for the e-commerce screen matrix.'),
            new InterfaceSurfaceAuditItem('shell.operations', 'Shell coverage', 'Operation workbench', 'solid', '/interfacing/operations', 'Shell-native EasyAdmin-like operation surface generated from CRUD resources.'),
            new InterfaceSurfaceAuditItem('shell.component-roadmap', 'Shell coverage', 'Component roadmap', 'solid', '/interfacing/components', 'Shell-native full component and required e-commerce screen roadmap.'),
            new InterfaceSurfaceAuditItem('shell.crud', 'Shell coverage', 'CRUD Explorer', 'solid', '/interfacing/crud/explorer', 'CRUD route grammar and resource list are rendered through the standard shell.'),
            new InterfaceSurfaceAuditItem('shell.legacy-screen-route', 'Shell coverage', 'Legacy /interfacing/screen/{id}', 'watch', '/interfacing/screen/{id}', 'Kept as compatibility route; canonical screen route is /interfacing/{id}.'),
        ];
    }

    /** @return list<InterfaceSurfaceAuditItem> */
    private function crudItems(): array
    {
        return [
            new InterfaceSurfaceAuditItem('crud.grammar.index', 'CRUD route grammar', 'Index route', 'solid', '/{resource}/', 'Generated from the canonical CRUD bridge resource path.'),
            new InterfaceSurfaceAuditItem('crud.grammar.new', 'CRUD route grammar', 'New route', 'solid', '/{resource}/new/', 'Create route follows the canonical CRUD bridge.'),
            new InterfaceSurfaceAuditItem('crud.grammar.show', 'CRUD route grammar', 'Show route', 'solid', '/{resource}/{id}', 'Identifier comes from the owning component at runtime.'),
            new InterfaceSurfaceAuditItem('crud.grammar.edit', 'CRUD route grammar', 'Edit route', 'solid', '/{resource}/edit/{id}', 'Identifier comes from the owning component at runtime.'),
            new InterfaceSurfaceAuditItem('crud.grammar.delete', 'CRUD route grammar', 'Delete route', 'solid', '/{resource}/delete/{id}', 'Destructive route is explicit and must be guarded by the owning component.'),
        ];
    }

    /** @return list<InterfaceSurfaceAuditItem> */
    private function dataBoundaryItems(): array
    {
        return [
            new InterfaceSurfaceAuditItem('data.boundary.fixtures', 'Data boundary', 'Component-owned fixtures', 'solid', '#component-fixtures', 'Business demo rows must come from component fixtures/providers, not from Interfacing runtime services.'),
            new InterfaceSurfaceAuditItem('data.boundary.samples', 'Data boundary', 'Sample identifiers', 'watch', '#sample-identifiers', 'Sample show/edit/delete links are navigation probes only; they must not be mistaken for stored Interfacing data.'),
            new InterfaceSurfaceAuditItem('data.boundary.demo-services', 'Data boundary', 'Runtime demo services', 'watch', '#runtime-demo-services', 'Demo providers are excluded from service discovery; remaining demo classes should stay dev/test only.'),
        ];
    }

    /** @return list<InterfaceSurfaceAuditItem> */
    private function componentCoverageItems(): array
    {
        $componentStatus = [];
        foreach ($this->screenCatalogProvider->provide() as $entry) {
            if (!$entry instanceof EcommerceScreenEntry || 'Interfacing' === $entry->component()) {
                continue;
            }

            $componentStatus[$entry->component()] ??= $entry->status();
            $componentStatus[$entry->component()] = $this->strongerStatus($componentStatus[$entry->component()], $entry->status());
        }

        $items = [];
        foreach ($componentStatus as $component => $status) {
            $items[] = new InterfaceSurfaceAuditItem(
                'component.'.strtolower($component),
                'Component coverage',
                $component,
                $this->surfaceStatus($status),
                '/interfacing/screens#'.strtolower($component),
                match ($status) {
                    'connected' => 'At least one live/shell-visible screen or route is connected for this component.',
                    'canonical' => 'Canonical CRUD route grammar is known, but host route/runtime may still be pending.',
                    default => 'Planned ecosystem resource; visible for navigation readiness but not guaranteed to be connected.',
                },
            );
        }

        return $items;
    }

    private function strongerStatus(string $left, string $right): string
    {
        return self::catalogStatusOrder($right) < self::catalogStatusOrder($left) ? $right : $left;
    }

    private function surfaceStatus(string $catalogStatus): string
    {
        return match ($catalogStatus) {
            'connected' => 'solid',
            'canonical' => 'watch',
            default => 'watch',
        };
    }

    private static function areaOrder(string $area): int
    {
        return match ($area) {
            'Shell coverage' => 10,
            'CRUD route grammar' => 20,
            'Data boundary' => 30,
            'Component coverage' => 40,
            default => 900,
        };
    }

    private static function statusOrder(string $status): int
    {
        return match ($status) {
            'solid' => 10,
            'watch' => 20,
            'drift' => 30,
            default => 900,
        };
    }

    private static function catalogStatusOrder(string $status): int
    {
        return match ($status) {
            'connected' => 10,
            'canonical' => 20,
            'planned' => 30,
            default => 900,
        };
    }
}
