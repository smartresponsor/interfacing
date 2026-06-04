<?php

declare(strict_types=1);

namespace App\Interfacing\Factory\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudAction;
use App\Interfacing\Contract\Crud\InterfaceCrudFilterField;
use App\Interfacing\Contract\Crud\InterfaceCrudFormField;
use App\Interfacing\Contract\Crud\InterfaceCrudFormSection;
use App\Interfacing\Contract\Crud\InterfaceCrudPreviewPage;
use App\Interfacing\Contract\Crud\InterfaceCrudPreviewRow;
use App\Interfacing\Contract\Crud\InterfaceCrudRouteContext;
use App\Interfacing\Contract\Crud\InterfaceCrudScreenContext;
use App\Interfacing\Contract\Crud\InterfaceCrudSidebarSection;
use App\Interfacing\Contract\Crud\InterfaceCrudTableColumn;
use App\Interfacing\Contract\Crud\InterfaceCrudWorkbenchView;
use App\Interfacing\Contract\Dto\InterfaceBillingMeterPage;
use App\Interfacing\Contract\Dto\InterfaceBillingMeterRow;
use App\Interfacing\Contract\Dto\InterfaceOrderSummaryPage;
use App\Interfacing\Contract\Dto\InterfaceOrderSummaryRow;

final readonly class InterfaceCrudWorkbenchFactory
{
    /**
     * @param array{status:string,createdFrom:string,createdTo:string} $filters
     * @param array<string, mixed>                                     $ctx
     */
    public function buildCrudPreviewView(InterfaceCrudPreviewPage $page, array $filters, array $ctx, InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext): InterfaceCrudWorkbenchView
    {
        $selectedRow = $this->resolveSelectedPreviewRow($page, $routeContext->displayIdentifier());
        $currentQuery = array_filter([
            'status' => $filters['status'],
            'createdFrom' => $filters['createdFrom'],
            'createdTo' => $filters['createdTo'],
        ], static fn (mixed $value): bool => '' !== (string) $value);

        $selectionFacts = $this->previewSelectionFacts($selectedRow);
        $formFields = $this->buildFormFields($routeContext, $selectionFacts);

        $rows = [];
        foreach ($page->items as $row) {
            $rows[] = [
                'id' => $row->identifier,
                'status' => $row->status,
                'createdAt' => $this->formatDateTime($row->occurredAtIso),
                'amount' => number_format($row->amountValue, 2).' '.$row->currencyCode,
                'customer' => $row->actorLabel ?? 'preview actor',
                '_actions' => $this->rowActions($routeContext, $screenContext, $row->identifier),
            ];
        }

        return new InterfaceCrudWorkbenchView(
            routeContext: $routeContext,
            screenContext: $screenContext,
            eyebrow: 'Ant Design / ProComponents discipline',
            title: 'CRUD Workbench · '.$routeContext->resourceLabel(),
            subtitle: 'Host-aligned CRUD body driven by neutral Interfacing preview DTOs and route semantics: resourcePath, operation, surface, identifier metadata, and identifier-kind addressing.',
            breadcrumbs: $routeContext->breadcrumbItems(),
            metaChips: [
                'resource: '.$routeContext->resourcePath,
                'resource label: '.$routeContext->resourceLabel(),
                'operation: '.$routeContext->operation,
                'surface: '.$routeContext->surface,
                'surface tone: '.$routeContext->surfaceLabel(),
                'identifier kind: '.$routeContext->identifierKindLabel(),
                'mode: '.$routeContext->mode(),
                'resource tone: '.$routeContext->resourceToneLabel(),
                'template intent: '.$screenContext->templateIntent,
                'access mode: '.$screenContext->accessMode,
                'capability: '.$screenContext->capabilityLabel,
                'ownership: '.$screenContext->ownershipLabel,
                'tenant: '.(string) ($ctx['tenantId'] ?? 'default'),
                'rows: '.$page->total,
            ],
            headerActions: $this->headerActions($routeContext, $screenContext, $currentQuery, $selectedRow?->identifier),
            panelTitle: 'CRUD command routing layer',
            panelHint: $routeContext->isAdminSurface() ? 'Admin surface keeps a denser command toolbar, destructive affordances, and '.strtolower($routeContext->resourceToneLabel()).'.' : 'Public surface keeps the same CRUD semantics but softens dangerous commands while preserving '.strtolower($routeContext->resourceToneLabel()).'.',
            panelMeta: sprintf('page %d · pageSize %d · %s · %s · %s', $page->page, $page->pageSize, $routeContext->identifierKindLabel(), $routeContext->vocabularyLead(), $screenContext->accessToneLabel()),
            filters: [
                new InterfaceCrudFilterField('status', $routeContext->statusFilterLabel(), 'select', $filters['status'], $routeContext->statusFilterOptions(), $routeContext->statusFilterPlaceholder(), 'Preview collection uses route-aware lifecycle vocabulary.'),
                new InterfaceCrudFilterField('createdFrom', $routeContext->dateFromFilterLabel(), 'date', $filters['createdFrom'], [], $routeContext->fromFilterPlaceholder(), 'Narrow the preview window from this date.'),
                new InterfaceCrudFilterField('createdTo', $routeContext->dateToFilterLabel(), 'date', $filters['createdTo'], [], $routeContext->toFilterPlaceholder(), 'Narrow the preview window up to this date.'),
            ],
            columns: [
                new InterfaceCrudTableColumn('id', $routeContext->identifierColumnLabel(), true),
                new InterfaceCrudTableColumn('status', $routeContext->statusColumnLabel(), false, true),
                new InterfaceCrudTableColumn('createdAt', $routeContext->primaryDateColumnLabel()),
                new InterfaceCrudTableColumn('amount', $routeContext->amountColumnLabel()),
                new InterfaceCrudTableColumn('customer', $routeContext->auxiliaryColumnLabel()),
            ],
            rows: $rows,
            emptyState: $routeContext->emptyStateLabel(),
            paginationLabel: $routeContext->paginationLabel(count($page->items), $page->total),
            formFields: $formFields,
            formSections: $this->buildFormSections($routeContext, $formFields),
            validationSummary: $this->buildValidationSummary($routeContext, $formFields),
            sidebarSections: $this->sidebarSectionsForMode($routeContext, [
                new InterfaceCrudSidebarSection(
                    title: $routeContext->routeContextSidebarTitle(),
                    facts: [
                        'Resource path' => $routeContext->resourcePath,
                        'Operation' => $routeContext->operation,
                        'Surface' => $routeContext->surface,
                        'Identifier field' => $routeContext->identifierField,
                        'Identifier value' => $routeContext->displayIdentifier(),
                        'Identifier kind' => $routeContext->identifierKindLabel(),
                        'Resource label' => $routeContext->resourceLabel(),
                        'Template intent' => $screenContext->templateIntent,
                        'Access mode' => $screenContext->accessMode,
                        'Capability' => $screenContext->capabilityLabel,
                        'Ownership' => $screenContext->ownershipLabel,
                        'Mutation tone' => $screenContext->mutationToneLabel(),
                    ],
                    note: 'This context matches the host CRUD endpoint pattern and is independent from the underlying entity type.',
                ),
                new InterfaceCrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: $selectionFacts,
                    note: 'Row detail facts are mapped from Interfacing neutral CRUD preview DTOs.',
                ),
                new InterfaceCrudSidebarSection(
                    title: $routeContext->commandSidebarTitle(),
                    facts: [
                        'Primary action' => $routeContext->adminPrimaryFormActionLabel(),
                        'Secondary action' => $routeContext->adminSecondaryFormActionLabel(),
                        'Destructive action' => $routeContext->adminDestructiveActionLabel(),
                        'Routing copy' => $routeContext->vocabularyLead(),
                        'Next step' => 'Owner component routing',
                    ],
                    note: $routeContext->isAdminSurface() ? 'Buttons below reflect the admin workbench density and destructive affordances.' : 'Buttons below stay aligned to CRUD semantics while hiding the heaviest destructive/public-unsafe affordances.',
                    actions: $this->commandActions($routeContext, $screenContext, $selectedRow?->identifier, $routeContext->adminSecondaryFormActionLabel()),
                ),
            ]),
        );
    }

    /**
     * @param array{status:string,createdFrom:string,createdTo:string} $filters
     * @param array<string, mixed>                                     $ctx
     */
    public function buildOrderSummaryView(InterfaceOrderSummaryPage $page, array $filters, array $ctx, InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext): InterfaceCrudWorkbenchView
    {
        $selectedRow = $this->resolveSelectedOrderRow($page, $routeContext->displayIdentifier());
        $currentQuery = array_filter([
            'status' => $filters['status'],
            'createdFrom' => $filters['createdFrom'],
            'createdTo' => $filters['createdTo'],
        ], static fn (mixed $value): bool => '' !== (string) $value);

        $selectionFacts = $this->orderSelectionFacts($selectedRow);
        $formFields = $this->buildFormFields($routeContext, $selectionFacts);

        $rows = [];
        foreach ($page->items as $row) {
            $rows[] = [
                'id' => $row->id,
                'status' => $row->status,
                'createdAt' => $this->formatDateTime($row->createdAtIso),
                'amount' => number_format($row->totalGross, 2).' '.$row->currencyCode,
                'customer' => $row->customerEmail ?? 'guest',
                '_actions' => $this->rowActions($routeContext, $screenContext, $row->id),
            ];
        }

        return new InterfaceCrudWorkbenchView(
            routeContext: $routeContext,
            screenContext: $screenContext,
            eyebrow: 'Ant Design / ProComponents discipline',
            title: 'CRUD Workbench · '.$routeContext->resourceLabel(),
            subtitle: 'Host-aligned CRUD body driven by route semantics: resourcePath, operation, surface, identifier metadata, and identifier-kind addressing.',
            breadcrumbs: $routeContext->breadcrumbItems(),
            metaChips: [
                'resource: '.$routeContext->resourcePath,
                'resource label: '.$routeContext->resourceLabel(),
                'operation: '.$routeContext->operation,
                'surface: '.$routeContext->surface,
                'surface tone: '.$routeContext->surfaceLabel(),
                'identifier kind: '.$routeContext->identifierKindLabel(),
                'mode: '.$routeContext->mode(),
                'resource tone: '.$routeContext->resourceToneLabel(),
                'template intent: '.$screenContext->templateIntent,
                'access mode: '.$screenContext->accessMode,
                'capability: '.$screenContext->capabilityLabel,
                'ownership: '.$screenContext->ownershipLabel,
                'tenant: '.(string) ($ctx['tenantId'] ?? 'default'),
                'rows: '.$page->total,
            ],
            headerActions: $this->headerActions($routeContext, $screenContext, $currentQuery, $selectedRow?->id),
            panelTitle: 'CRUD command routing layer',
            panelHint: $routeContext->isAdminSurface() ? 'Admin surface keeps a denser command toolbar, destructive affordances, and '.strtolower($routeContext->resourceToneLabel()).'.' : 'Public surface keeps the same CRUD semantics but softens dangerous commands while preserving '.strtolower($routeContext->resourceToneLabel()).'.',
            panelMeta: sprintf('page %d · pageSize %d · %s · %s · %s', $page->page, $page->pageSize, $routeContext->identifierKindLabel(), $routeContext->vocabularyLead(), $screenContext->accessToneLabel()),
            filters: [
                new InterfaceCrudFilterField('status', $routeContext->statusFilterLabel(), 'select', $filters['status'], $routeContext->statusFilterOptions(), $routeContext->statusFilterPlaceholder(), 'Order collection uses request lifecycle vocabulary.'),
                new InterfaceCrudFilterField('createdFrom', $routeContext->dateFromFilterLabel(), 'date', $filters['createdFrom'], [], $routeContext->fromFilterPlaceholder(), 'Narrow the order intake window from this date.'),
                new InterfaceCrudFilterField('createdTo', $routeContext->dateToFilterLabel(), 'date', $filters['createdTo'], [], $routeContext->toFilterPlaceholder(), 'Narrow the order intake window up to this date.'),
            ],
            columns: [
                new InterfaceCrudTableColumn('id', $routeContext->identifierColumnLabel(), true),
                new InterfaceCrudTableColumn('status', $routeContext->statusColumnLabel(), false, true),
                new InterfaceCrudTableColumn('createdAt', $routeContext->primaryDateColumnLabel()),
                new InterfaceCrudTableColumn('amount', $routeContext->amountColumnLabel()),
                new InterfaceCrudTableColumn('customer', $routeContext->auxiliaryColumnLabel()),
            ],
            rows: $rows,
            emptyState: $routeContext->emptyStateLabel(),
            paginationLabel: $routeContext->paginationLabel(count($page->items), $page->total),
            formFields: $formFields,
            formSections: $this->buildFormSections($routeContext, $formFields),
            validationSummary: $this->buildValidationSummary($routeContext, $formFields),
            sidebarSections: $this->sidebarSectionsForMode($routeContext, [
                new InterfaceCrudSidebarSection(
                    title: $routeContext->routeContextSidebarTitle(),
                    facts: [
                        'Resource path' => $routeContext->resourcePath,
                        'Operation' => $routeContext->operation,
                        'Surface' => $routeContext->surface,
                        'Identifier field' => $routeContext->identifierField,
                        'Identifier value' => $routeContext->displayIdentifier(),
                        'Identifier kind' => $routeContext->identifierKindLabel(),
                        'Resource label' => $routeContext->resourceLabel(),
                        'Template intent' => $screenContext->templateIntent,
                        'Access mode' => $screenContext->accessMode,
                        'Capability' => $screenContext->capabilityLabel,
                        'Ownership' => $screenContext->ownershipLabel,
                        'Mutation tone' => $screenContext->mutationToneLabel(),
                    ],
                    note: 'This context matches the host CRUD endpoint pattern and is independent from the underlying entity type.',
                ),
                new InterfaceCrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: $selectionFacts,
                    note: 'Row detail facts now follow the resource-aware schema instead of a generic selected-record block.',
                ),
                new InterfaceCrudSidebarSection(
                    title: $routeContext->commandSidebarTitle(),
                    facts: [
                        'Primary action' => $routeContext->adminPrimaryFormActionLabel(),
                        'Secondary action' => $routeContext->adminSecondaryFormActionLabel(),
                        'Destructive action' => $routeContext->adminDestructiveActionLabel(),
                        'Routing copy' => $routeContext->vocabularyLead(),
                        'Next step' => 'Fulfillment routing',
                    ],
                    note: $routeContext->isAdminSurface() ? 'Buttons below reflect the admin workbench density and destructive affordances.' : 'Buttons below stay aligned to CRUD semantics while hiding the heaviest destructive/public-unsafe affordances.',
                    actions: $this->commandActions($routeContext, $screenContext, $selectedRow?->id, $routeContext->adminSecondaryFormActionLabel()),
                ),
            ]),
        );
    }

    /**
     * @param array{status:string,periodFrom:string,periodTo:string} $filters
     * @param array<string, mixed>                                   $ctx
     */
    public function buildBillingMeterView(InterfaceBillingMeterPage $page, array $filters, array $ctx, InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext): InterfaceCrudWorkbenchView
    {
        $selectedRow = $this->resolveSelectedBillingRow($page, $routeContext->displayIdentifier());
        $currentQuery = array_filter([
            'status' => $filters['status'],
            'periodFrom' => $filters['periodFrom'],
            'periodTo' => $filters['periodTo'],
        ], static fn (mixed $value): bool => '' !== (string) $value);

        $selectionFacts = $this->billingSelectionFacts($selectedRow);
        $formFields = $this->buildFormFields($routeContext, $selectionFacts);

        $rows = [];
        foreach ($page->items as $row) {
            $rows[] = [
                'id' => $row->id,
                'status' => $row->status,
                'period' => $row->periodFromIso.' → '.$row->periodToIso,
                'amount' => '$'.number_format($row->amount, 2),
                '_actions' => $this->rowActions($routeContext, $screenContext, $row->id),
            ];
        }

        return new InterfaceCrudWorkbenchView(
            routeContext: $routeContext,
            screenContext: $screenContext,
            eyebrow: 'Ant Design / ProComponents discipline',
            title: 'CRUD Workbench · '.$routeContext->resourceLabel(),
            subtitle: 'Shared CRUD center-body mapped to billing data while honoring host CRUD routing semantics and identifier-kind addressing.',
            breadcrumbs: $routeContext->breadcrumbItems(),
            metaChips: [
                'resource: '.$routeContext->resourcePath,
                'resource label: '.$routeContext->resourceLabel(),
                'operation: '.$routeContext->operation,
                'surface: '.$routeContext->surface,
                'surface tone: '.$routeContext->surfaceLabel(),
                'identifier kind: '.$routeContext->identifierKindLabel(),
                'mode: '.$routeContext->mode(),
                'resource tone: '.$routeContext->resourceToneLabel(),
                'template intent: '.$screenContext->templateIntent,
                'access mode: '.$screenContext->accessMode,
                'capability: '.$screenContext->capabilityLabel,
                'ownership: '.$screenContext->ownershipLabel,
                'tenant: '.(string) ($ctx['tenantId'] ?? 'default'),
                'rows: '.$page->total,
            ],
            headerActions: $this->headerActions($routeContext, $screenContext, $currentQuery, $selectedRow?->id),
            panelTitle: 'CRUD command routing layer',
            panelHint: $routeContext->isAdminSurface() ? 'Same center-body renderer with admin-grade command density and '.strtolower($routeContext->resourceToneLabel()).'.' : 'Same center-body renderer with public-safe presentation and lighter command density while preserving '.strtolower($routeContext->resourceToneLabel()).'.',
            panelMeta: sprintf('page %d · pageSize %d · %s · %s · %s', $page->page, $page->pageSize, $routeContext->identifierKindLabel(), $routeContext->vocabularyLead(), $screenContext->accessToneLabel()),
            filters: [
                new InterfaceCrudFilterField('status', $routeContext->statusFilterLabel(), 'select', $filters['status'], $routeContext->statusFilterOptions(), $routeContext->statusFilterPlaceholder(), 'Meter collection uses reading lifecycle vocabulary.'),
                new InterfaceCrudFilterField('periodFrom', $routeContext->dateFromFilterLabel(), 'date', $filters['periodFrom'], [], $routeContext->fromFilterPlaceholder(), 'Narrow the reading window from this date.'),
                new InterfaceCrudFilterField('periodTo', $routeContext->dateToFilterLabel(), 'date', $filters['periodTo'], [], $routeContext->toFilterPlaceholder(), 'Narrow the reading window up to this date.'),
            ],
            columns: [
                new InterfaceCrudTableColumn('id', $routeContext->identifierColumnLabel(), true),
                new InterfaceCrudTableColumn('status', $routeContext->statusColumnLabel(), false, true),
                new InterfaceCrudTableColumn('period', $routeContext->primaryDateColumnLabel()),
                new InterfaceCrudTableColumn('amount', $routeContext->amountColumnLabel()),
            ],
            rows: $rows,
            emptyState: $routeContext->emptyStateLabel(),
            paginationLabel: $routeContext->paginationLabel(count($page->items), $page->total),
            formFields: $formFields,
            formSections: $this->buildFormSections($routeContext, $formFields),
            validationSummary: $this->buildValidationSummary($routeContext, $formFields),
            sidebarSections: $this->sidebarSectionsForMode($routeContext, [
                new InterfaceCrudSidebarSection(
                    title: $routeContext->routeContextSidebarTitle(),
                    facts: [
                        'Resource path' => $routeContext->resourcePath,
                        'Operation' => $routeContext->operation,
                        'Surface' => $routeContext->surface,
                        'Identifier field' => $routeContext->identifierField,
                        'Identifier value' => $routeContext->displayIdentifier(),
                        'Identifier kind' => $routeContext->identifierKindLabel(),
                        'Resource label' => $routeContext->resourceLabel(),
                        'Template intent' => $screenContext->templateIntent,
                        'Access mode' => $screenContext->accessMode,
                        'Capability' => $screenContext->capabilityLabel,
                        'Ownership' => $screenContext->ownershipLabel,
                        'Mutation tone' => $screenContext->mutationToneLabel(),
                    ],
                    note: 'Host-facing CRUD path semantics stay stable whether the resource is category, vendor, user, meter, or something else.',
                ),
                new InterfaceCrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: $selectionFacts,
                ),
                new InterfaceCrudSidebarSection(
                    title: $routeContext->commandSidebarTitle(),
                    facts: [
                        'Primary action' => $routeContext->adminPrimaryFormActionLabel(),
                        'Secondary action' => 'Recalculate',
                        'Destructive action' => $routeContext->adminDestructiveActionLabel(),
                        'Routing copy' => $routeContext->vocabularyLead(),
                        'Next step' => 'Settlement routing',
                    ],
                    note: $routeContext->isAdminSurface() ? 'Route-aware actions below match the denser admin settlement workflow.' : 'Route-aware actions below keep billing navigation lighter for public-safe rendering.',
                    actions: $this->commandActions($routeContext, $screenContext, $selectedRow?->id, 'Recalculate'),
                ),
            ]),
        );
    }

    /**
     * @return list<InterfaceCrudAction>
     */
    private function headerActions(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, array $currentQuery, string|int|null $selectedIdentifier): array
    {
        if ($screenContext->isReadonly()) {
            return [
                new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                new InterfaceCrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
            ];
        }

        return match ($routeContext->mode()) {
            'collection' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->createActionLabel(), $this->newHref($routeContext, $screenContext), 'primary'),
                    new InterfaceCrudAction($routeContext->refreshActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->createActionLabel(), $this->newHref($routeContext, $screenContext), 'primary'),
                    new InterfaceCrudAction($routeContext->refreshActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ],
            'form' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->adminSecondaryFormActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction('Cancel', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->publicPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->publicSecondaryFormActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction('Back', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ],
            'destructive' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new InterfaceCrudAction('Cancel', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->publicDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction('Back', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                ],
            default => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new InterfaceCrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ],
        };
    }

    /**
     * @return list<InterfaceCrudAction>
     */
    private function rowActions(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, string|int|null $identifier): array
    {
        return match ($routeContext->mode()) {
            'collection' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                    new InterfaceCrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $identifier)),
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $identifier), 'danger'),
                ]
                : [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, [], $identifier)),
                ],
            'destructive' => [
                new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
            ],
            default => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                    new InterfaceCrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $identifier)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                ],
        };
    }

    /**
     * @return list<InterfaceCrudAction>
     */
    private function commandActions(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, string|int|null $selectedIdentifier, string $secondaryLabel): array
    {
        if (!$screenContext->mutationAllowed) {
            return [
                new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                new InterfaceCrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext)),
            ];
        }

        return match ($routeContext->mode()) {
            'form' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($secondaryLabel, $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->publicPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->publicSecondaryFormActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ],
            'destructive' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new InterfaceCrudAction('Cancel', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ]
                : [
                    new InterfaceCrudAction($routeContext->publicDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction('Back', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ],
            'detail' => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                ]
                : [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, [], $selectedIdentifier)),
                ],
            default => $routeContext->isAdminSurface()
                ? [
                    new InterfaceCrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($secondaryLabel, $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new InterfaceCrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                ]
                : [
                    new InterfaceCrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new InterfaceCrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, [], $selectedIdentifier)),
                ],
        };
    }

    /**
     * @param list<InterfaceCrudSidebarSection> $sections
     *
     * @return list<InterfaceCrudSidebarSection>
     */
    private function sidebarSectionsForMode(InterfaceCrudRouteContext $routeContext, array $sections): array
    {
        $filtered = match ($routeContext->mode()) {
            'collection' => $sections,
            'form' => array_values(array_filter(
                $sections,
                static fn (InterfaceCrudSidebarSection $section): bool => in_array($section->title, ['Route context', 'Command form'], true),
            )),
            'destructive' => array_values(array_filter(
                $sections,
                static fn (InterfaceCrudSidebarSection $section): bool => in_array($section->title, ['Route context'], true),
            )),
            default => array_values(array_filter(
                $sections,
                static fn (InterfaceCrudSidebarSection $section): bool => in_array($section->title, ['Route context', 'Selected order', 'Selected meter', 'Command form'], true),
            )),
        };

        if ($routeContext->isAdminSurface()) {
            return $filtered;
        }

        return array_values(array_map(
            static fn (InterfaceCrudSidebarSection $section): InterfaceCrudSidebarSection => new InterfaceCrudSidebarSection(
                title: $section->title,
                facts: $section->facts,
                note: trim(('' !== $section->note ? $section->note.' ' : '').'Public surface keeps this sidebar lighter and avoids operator-heavy cues.'),
                actions: array_values(array_filter(
                    $section->actions,
                    static fn (InterfaceCrudAction $action): bool => 'danger' !== $action->variant && !in_array($action->label, ['Recalculate', 'Retire meter', 'Cancel order'], true),
                )),
            ),
            $filtered,
        ));
    }

    /**
     * @return array<string, scalar|null>
     */
    private function previewSelectionFacts(?InterfaceCrudPreviewRow $selectedRow): array
    {
        if (null === $selectedRow) {
            return [
                'Preview ref' => null,
                'Workflow state' => null,
                'Occurred at' => null,
                'Amount' => null,
                'Actor' => null,
            ];
        }

        return [
            'Preview ref' => $selectedRow->identifier,
            'Workflow state' => $selectedRow->status,
            'Occurred at' => $this->formatDateTime($selectedRow->occurredAtIso),
            'Amount' => number_format($selectedRow->amountValue, 2).' '.$selectedRow->currencyCode,
            'Actor' => $selectedRow->actorLabel ?? 'preview actor',
        ];
    }

    /**
     * @return array<string, scalar|null>
     */
    private function orderSelectionFacts(?InterfaceOrderSummaryRow $selectedRow): array
    {
        if (null === $selectedRow) {
            return [
                'Request ref' => null,
                'Workflow state' => null,
                'Submitted at' => null,
                'Gross total' => null,
                'Customer email' => null,
            ];
        }

        return [
            'Request ref' => $selectedRow->id,
            'Workflow state' => $selectedRow->status,
            'Submitted at' => $this->formatDateTime($selectedRow->createdAtIso),
            'Gross total' => number_format($selectedRow->totalGross, 2).' '.$selectedRow->currencyCode,
            'Customer email' => $selectedRow->customerEmail ?? 'guest',
        ];
    }

    /**
     * @return array<string, scalar|null>
     */
    private function billingSelectionFacts(?InterfaceBillingMeterRow $selectedRow): array
    {
        if (null === $selectedRow) {
            return [
                'Meter ref' => null,
                'Reading state' => null,
                'Reading window' => null,
                'Billed amount' => null,
                'Settlement state' => null,
            ];
        }

        return [
            'Meter ref' => $selectedRow->id,
            'Reading state' => $selectedRow->status,
            'Reading window' => $selectedRow->periodFromIso.' → '.$selectedRow->periodToIso,
            'Billed amount' => '$'.number_format($selectedRow->amount, 2),
            'Settlement state' => 'pending reconciliation',
        ];
    }

    /**
     * @param array<string, scalar|null> $facts
     *
     * @return list<InterfaceCrudFormField>
     */
    private function buildFormFields(InterfaceCrudRouteContext $routeContext, array $facts): array
    {
        $fields = [];

        foreach ($routeContext->formFieldBlueprints($facts) as $blueprint) {
            $state = $this->validationStateForField($routeContext, $blueprint['name'], $blueprint['value']);
            $fields[] = new InterfaceCrudFormField(
                name: $blueprint['name'],
                label: $blueprint['label'],
                type: $blueprint['type'],
                value: $blueprint['value'],
                placeholder: $blueprint['placeholder'],
                helpText: $blueprint['helpText'],
                options: $blueprint['options'],
                required: $this->isRequiredField($routeContext, $blueprint['name']),
                validationState: $state,
                errorText: $this->validationMessageForField($routeContext, $blueprint['name'], $blueprint['value'], $state),
            );
        }

        return $fields;
    }

    /**
     * @param list<InterfaceCrudFormField> $fields
     *
     * @return list<InterfaceCrudFormSection>
     */
    private function buildFormSections(InterfaceCrudRouteContext $routeContext, array $fields): array
    {
        $indexed = [];
        foreach ($fields as $field) {
            $indexed[$field->name] = $field;
        }

        $sections = [];
        foreach ($routeContext->formSectionBlueprints() as $sectionBlueprint) {
            $sectionFields = [];
            foreach ($sectionBlueprint['fieldNames'] as $fieldName) {
                if (isset($indexed[$fieldName])) {
                    $sectionFields[] = $indexed[$fieldName];
                }
            }

            if ([] !== $sectionFields) {
                $sections[] = new InterfaceCrudFormSection(
                    title: $sectionBlueprint['title'],
                    description: $sectionBlueprint['description'],
                    fields: $sectionFields,
                );
            }
        }

        return $sections;
    }

    /**
     * @param list<InterfaceCrudFormField> $fields
     *
     * @return list<string>
     */
    private function buildValidationSummary(InterfaceCrudRouteContext $routeContext, array $fields): array
    {
        $summary = [];
        foreach ($fields as $field) {
            if ('' !== $field->errorText) {
                $summary[] = $field->label.': '.$field->errorText;
            }
        }

        if ([] !== $summary) {
            return $summary;
        }

        return [$routeContext->formValidationSummaryLead()];
    }

    private function isRequiredField(InterfaceCrudRouteContext $routeContext, string $fieldName): bool
    {
        return in_array($fieldName, $routeContext->requiredFieldNames(), true);
    }

    private function validationStateForField(InterfaceCrudRouteContext $routeContext, string $fieldName, string $value): string
    {
        if ($this->isRequiredField($routeContext, $fieldName) && '' === trim($value)) {
            return 'error';
        }

        if (in_array($fieldName, $routeContext->warningFieldNames(), true)) {
            return 'warning';
        }

        return $this->isRequiredField($routeContext, $fieldName) ? 'success' : 'default';
    }

    private function validationMessageForField(InterfaceCrudRouteContext $routeContext, string $fieldName, string $value, string $state): string
    {
        if ('error' === $state) {
            return $routeContext->requiredFieldMessage($fieldName);
        }

        if ('warning' === $state) {
            return $routeContext->warningFieldMessage($fieldName, $value);
        }

        return '';
    }

    private function indexHref(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, array $query = []): string
    {
        return $this->appendQuery($screenContext->urls['index'], $query);
    }

    private function newHref(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext): string
    {
        return $screenContext->urls['new'];
    }

    private function showHref(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->indexHref($routeContext, $screenContext);
        }

        return str_replace('{identifier}', rawurlencode((string) $identifier), $screenContext->urls['show']);
    }

    private function editHref(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->newHref($routeContext, $screenContext);
        }

        return str_replace('{identifier}', rawurlencode((string) $identifier), $screenContext->urls['edit']);
    }

    private function deleteHref(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->indexHref($routeContext, $screenContext);
        }

        return str_replace('{identifier}', rawurlencode((string) $identifier), $screenContext->urls['delete']);
    }

    private function nextHref(InterfaceCrudRouteContext $routeContext, InterfaceCrudScreenContext $screenContext, array $query, string|int|null $identifier): string
    {
        $query['selected'] = null === $identifier ? null : (string) $identifier;
        $query['step'] = 'next';

        return $this->appendQuery($screenContext->urls['next'], array_filter($query, static fn (mixed $value): bool => null !== $value && '' !== (string) $value));
    }

    private function appendQuery(string $path, array $query): string
    {
        if ([] === $query) {
            return $path;
        }

        return $path.'?'.http_build_query($query);
    }

    private function resolveSelectedPreviewRow(InterfaceCrudPreviewPage $page, ?string $selectedId): ?InterfaceCrudPreviewRow
    {
        if ('' === (string) $selectedId) {
            return $page->items[0] ?? null;
        }

        foreach ($page->items as $row) {
            if ($row->identifier === $selectedId) {
                return $row;
            }
        }

        return $page->items[0] ?? null;
    }

    private function resolveSelectedOrderRow(InterfaceOrderSummaryPage $page, ?string $selectedId): ?InterfaceOrderSummaryRow
    {
        if ('' === (string) $selectedId) {
            return $page->items[0] ?? null;
        }

        foreach ($page->items as $row) {
            if ($row->id === $selectedId) {
                return $row;
            }
        }

        return $page->items[0] ?? null;
    }

    private function resolveSelectedBillingRow(InterfaceBillingMeterPage $page, ?string $selectedId): ?InterfaceBillingMeterRow
    {
        if ('' === (string) $selectedId) {
            return $page->items[0] ?? null;
        }

        foreach ($page->items as $row) {
            if ($row->id === $selectedId) {
                return $row;
            }
        }

        return $page->items[0] ?? null;
    }

    private function formatDateTime(string $iso): string
    {
        try {
            return (new \DateTimeImmutable($iso))->format('Y-m-d H:i');
        } catch (\Throwable) {
            return $iso;
        }
    }
}
