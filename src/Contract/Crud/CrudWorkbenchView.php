<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class CrudWorkbenchView
{
    /**
     * @param list<string> $breadcrumbs
     * @param list<string> $metaChips
     * @param list<CrudAction> $headerActions
     * @param list<CrudFilterField> $filters
     * @param list<CrudTableColumn> $columns
     * @param list<array<string, scalar|null|array<int, CrudAction>>> $rows
     * @param list<CrudFormField> $formFields
     * @param list<CrudFormSection> $formSections
     * @param list<string> $validationSummary
     * @param list<CrudSidebarSection> $sidebarSections
     */
    public function __construct(
        public CrudRouteContext $routeContext,
        public CrudScreenContext $screenContext,
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
