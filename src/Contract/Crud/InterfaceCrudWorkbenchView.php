<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class InterfaceCrudWorkbenchView
{
    /**
     * @param list<string>                                                     $breadcrumbs
     * @param list<string>                                                     $metaChips
     * @param list<InterfaceCrudAction>                                        $headerActions
     * @param list<InterfaceCrudFilterField>                                   $filters
     * @param list<InterfaceCrudTableColumn>                                   $columns
     * @param list<array<string, scalar|array<int, InterfaceCrudAction>|null>> $rows
     * @param list<InterfaceCrudFormField>                                     $formFields
     * @param list<InterfaceCrudFormSection>                                   $formSections
     * @param list<string>                                                     $validationSummary
     * @param list<InterfaceCrudSidebarSection>                                $sidebarSections
     */
    public function __construct(
        public InterfaceCrudRouteContext $routeContext,
        public InterfaceCrudScreenContext $screenContext,
        public string $eyebrow,
        public string $title,
        public string $subtitle,
        public array $breadcrumbs,
        public array $metaChips,
        public array $headerActions,
        public string $panelTitle,
        public string $panelHint,
        public string $panelMeta,
        public array $filters,
        public array $columns,
        public array $rows,
        public string $emptyState,
        public string $paginationLabel,
        public array $formFields,
        public array $formSections,
        public array $validationSummary,
        public array $sidebarSections,
    ) {
    }
}
