<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudAction;
use App\Interfacing\Contract\Crud\CrudFilterField;
use App\Interfacing\Contract\Crud\CrudFormField;
use App\Interfacing\Contract\Crud\CrudFormSection;
use App\Interfacing\Contract\Crud\CrudRouteContext;
use App\Interfacing\Contract\Crud\CrudScreenContext;
use App\Interfacing\Contract\Crud\CrudSidebarSection;
use App\Interfacing\Contract\Crud\CrudTableColumn;
use App\Interfacing\Contract\Crud\CrudWorkbenchView;
use App\Interfacing\Contract\Dto\BillingMeterPage;
use App\Interfacing\Contract\Dto\BillingMeterRow;
use App\Interfacing\Contract\Dto\OrderSummaryPage;
use App\Interfacing\Contract\Dto\OrderSummaryRow;

final readonly class CrudWorkbenchFactory
{
    /**
     * @param array{status:string,createdFrom:string,createdTo:string} $filters
     * @param array<string, mixed> $ctx
     */
    public function buildOrderSummaryView(OrderSummaryPage $page, array $filters, array $ctx, CrudRouteContext $routeContext, CrudScreenContext $screenContext): CrudWorkbenchView
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

        return new CrudWorkbenchView(
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
                new CrudFilterField('status', $routeContext->statusFilterLabel(), 'select', $filters['status'], $routeContext->statusFilterOptions(), $routeContext->statusFilterPlaceholder(), 'Order collection uses request lifecycle vocabulary.'),
                new CrudFilterField('createdFrom', $routeContext->dateFromFilterLabel(), 'date', $filters['createdFrom'], [], $routeContext->fromFilterPlaceholder(), 'Narrow the order intake window from this date.'),
                new CrudFilterField('createdTo', $routeContext->dateToFilterLabel(), 'date', $filters['createdTo'], [], $routeContext->toFilterPlaceholder(), 'Narrow the order intake window up to this date.'),
            ],
            columns: [
                new CrudTableColumn('id', $routeContext->identifierColumnLabel(), true),
                new CrudTableColumn('status', $routeContext->statusColumnLabel(), false, true),
                new CrudTableColumn('createdAt', $routeContext->primaryDateColumnLabel()),
                new CrudTableColumn('amount', $routeContext->amountColumnLabel()),
                new CrudTableColumn('customer', $routeContext->auxiliaryColumnLabel()),
            ],
            rows: $rows,
            emptyState: $routeContext->emptyStateLabel(),
            paginationLabel: $routeContext->paginationLabel(count($page->items), $page->total),
            formFields: $formFields,
            formSections: $this->buildFormSections($routeContext, $formFields),
            validationSummary: $this->buildValidationSummary($routeContext, $formFields),
            sidebarSections: $this->sidebarSectionsForMode($routeContext, [
                new CrudSidebarSection(
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
                new CrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: $selectionFacts,
                    note: 'Row detail facts now follow the resource-aware schema instead of a generic selected-record block.',
                ),
                new CrudSidebarSection(
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
     * @param array<string, mixed> $ctx
     */
    public function buildBillingMeterView(BillingMeterPage $page, array $filters, array $ctx, CrudRouteContext $routeContext, CrudScreenContext $screenContext): CrudWorkbenchView
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

        return new CrudWorkbenchView(
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
                new CrudFilterField('status', $routeContext->statusFilterLabel(), 'select', $filters['status'], $routeContext->statusFilterOptions(), $routeContext->statusFilterPlaceholder(), 'Meter collection uses reading lifecycle vocabulary.'),
                new CrudFilterField('periodFrom', $routeContext->dateFromFilterLabel(), 'date', $filters['periodFrom'], [], $routeContext->fromFilterPlaceholder(), 'Narrow the reading window from this date.'),
                new CrudFilterField('periodTo', $routeContext->dateToFilterLabel(), 'date', $filters['periodTo'], [], $routeContext->toFilterPlaceholder(), 'Narrow the reading window up to this date.'),
            ],
            columns: [
                new CrudTableColumn('id', $routeContext->identifierColumnLabel(), true),
                new CrudTableColumn('status', $routeContext->statusColumnLabel(), false, true),
                new CrudTableColumn('period', $routeContext->primaryDateColumnLabel()),
                new CrudTableColumn('amount', $routeContext->amountColumnLabel()),
            ],
            rows: $rows,
            emptyState: $routeContext->emptyStateLabel(),
            paginationLabel: $routeContext->paginationLabel(count($page->items), $page->total),
            formFields: $formFields,
            formSections: $this->buildFormSections($routeContext, $formFields),
            validationSummary: $this->buildValidationSummary($routeContext, $formFields),
            sidebarSections: $this->sidebarSectionsForMode($routeContext, [
                new CrudSidebarSection(
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
                new CrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: $selectionFacts,
                ),
                new CrudSidebarSection(
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
     * @return list<CrudAction>
     */
    private function headerActions(CrudRouteContext $routeContext, CrudScreenContext $screenContext, array $currentQuery, string|int|null $selectedIdentifier): array
    {
        if ($screenContext->isReadonly()) {
            return [
                new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
            ];
        }

        return match ($routeContext->mode()) {
            'collection' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->createActionLabel(), $this->newHref($routeContext, $screenContext), 'primary'),
                    new CrudAction($routeContext->refreshActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->createActionLabel(), $this->newHref($routeContext, $screenContext), 'primary'),
                    new CrudAction($routeContext->refreshActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ],
            'form' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->adminSecondaryFormActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction('Cancel', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->publicPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->publicSecondaryFormActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction('Back', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ],
            'destructive' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new CrudAction('Cancel', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                ]
                : [
                    new CrudAction($routeContext->publicDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction('Back', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                ],
            default => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext, $currentQuery)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, $currentQuery, $selectedIdentifier)),
                ],
        };
    }

    /**
     * @return list<CrudAction>
     */
    private function rowActions(CrudRouteContext $routeContext, CrudScreenContext $screenContext, string|int|null $identifier): array
    {
        return match ($routeContext->mode()) {
            'collection' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $identifier)),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $identifier), 'danger'),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $screenContext, [], $identifier)),
                ],
            'destructive' => [
                new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
            ],
            default => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $identifier)),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $identifier)),
                ],
        };
    }

    /**
     * @return list<CrudAction>
     */
    private function commandActions(CrudRouteContext $routeContext, CrudScreenContext $screenContext, string|int|null $selectedIdentifier, string $secondaryLabel): array
    {
        if (!$screenContext->mutationAllowed) {
            return [
                new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $screenContext)),
            ];
        }

        return match ($routeContext->mode()) {
            'form' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($secondaryLabel, $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->publicPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->publicSecondaryFormActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ],
            'destructive' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                    new CrudAction('Cancel', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->publicDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction('Back', $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                ],
            'detail' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, [], $selectedIdentifier)),
                ],
            default => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($secondaryLabel, $this->showHref($routeContext, $screenContext, $selectedIdentifier)),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $screenContext, $selectedIdentifier), 'danger'),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $screenContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, [], $selectedIdentifier)),
                ],
        };
    }

    /**
     * @param list<CrudSidebarSection> $sections
     *
     * @return list<CrudSidebarSection>
     */
    private function sidebarSectionsForMode(CrudRouteContext $routeContext, array $sections): array
    {
        $filtered = match ($routeContext->mode()) {
            'collection' => $sections,
            'form' => array_values(array_filter(
                $sections,
                static fn (CrudSidebarSection $section): bool => in_array($section->title, ['Route context', 'Command form'], true),
            )),
            'destructive' => array_values(array_filter(
                $sections,
                static fn (CrudSidebarSection $section): bool => in_array($section->title, ['Route context'], true),
            )),
            default => array_values(array_filter(
                $sections,
                static fn (CrudSidebarSection $section): bool => in_array($section->title, ['Route context', 'Selected order', 'Selected meter', 'Command form'], true),
            )),
        };

        if ($routeContext->isAdminSurface()) {
            return $filtered;
        }

        return array_values(array_map(
            static fn (CrudSidebarSection $section): CrudSidebarSection => new CrudSidebarSection(
                title: $section->title,
                facts: $section->facts,
                note: trim(($section->note !== '' ? $section->note.' ' : '').'Public surface keeps this sidebar lighter and avoids operator-heavy cues.'),
                actions: array_values(array_filter(
                    $section->actions,
                    static fn (CrudAction $action): bool => 'danger' !== $action->variant && !in_array($action->label, ['Recalculate', 'Retire meter', 'Cancel order'], true),
                )),
            ),
            $filtered,
        ));
    }

    /**
     * @return array<string, scalar|null>
     */
    private function orderSelectionFacts(?OrderSummaryRow $selectedRow): array
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
    private function billingSelectionFacts(?BillingMeterRow $selectedRow): array
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
     * @return list<CrudFormField>
     */
    private function buildFormFields(CrudRouteContext $routeContext, array $facts): array
    {
        $fields = [];

        foreach ($routeContext->formFieldBlueprints($facts) as $blueprint) {
            $state = $this->validationStateForField($routeContext, $blueprint['name'], $blueprint['value']);
            $fields[] = new CrudFormField(
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
     * @param list<CrudFormField> $fields
     *
     * @return list<CrudFormSection>
     */
    private function buildFormSections(CrudRouteContext $routeContext, array $fields): array
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
                $sections[] = new CrudFormSection(
                    title: $sectionBlueprint['title'],
                    description: $sectionBlueprint['description'],
                    fields: $sectionFields,
                );
            }
        }

        return $sections;
    }

    /**
     * @param list<CrudFormField> $fields
     *
     * @return list<string>
     */
    private function buildValidationSummary(CrudRouteContext $routeContext, array $fields): array
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

    private function isRequiredField(CrudRouteContext $routeContext, string $fieldName): bool
    {
        return in_array($fieldName, $routeContext->requiredFieldNames(), true);
    }

    private function validationStateForField(CrudRouteContext $routeContext, string $fieldName, string $value): string
    {
        if ($this->isRequiredField($routeContext, $fieldName) && '' === trim($value)) {
            return 'error';
        }

        if (in_array($fieldName, $routeContext->warningFieldNames(), true)) {
            return 'warning';
        }

        return $this->isRequiredField($routeContext, $fieldName) ? 'success' : 'default';
    }

    private function validationMessageForField(CrudRouteContext $routeContext, string $fieldName, string $value, string $state): string
    {
        if ('error' === $state) {
            return $routeContext->requiredFieldMessage($fieldName);
        }

        if ('warning' === $state) {
            return $routeContext->warningFieldMessage($fieldName, $value);
        }

        return '';
    }

    private function indexHref(CrudRouteContext $routeContext, CrudScreenContext $screenContext, array $query = []): string
    {
        return $this->appendQuery($screenContext->urls['index'], $query);
    }

    private function newHref(CrudRouteContext $routeContext, CrudScreenContext $screenContext): string
    {
        return $screenContext->urls['new'];
    }

    private function showHref(CrudRouteContext $routeContext, CrudScreenContext $screenContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->indexHref($routeContext, $screenContext);
        }

        return str_replace('{identifier}', rawurlencode((string) $identifier), $screenContext->urls['show']);
    }

    private function editHref(CrudRouteContext $routeContext, CrudScreenContext $screenContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->newHref($routeContext, $screenContext);
        }

        return str_replace('{identifier}', rawurlencode((string) $identifier), $screenContext->urls['edit']);
    }

    private function deleteHref(CrudRouteContext $routeContext, CrudScreenContext $screenContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->indexHref($routeContext, $screenContext);
        }

        return str_replace('{identifier}', rawurlencode((string) $identifier), $screenContext->urls['delete']);
    }

    private function nextHref(CrudRouteContext $routeContext, CrudScreenContext $screenContext, array $query, string|int|null $identifier): string
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

    private function resolveSelectedOrderRow(OrderSummaryPage $page, ?string $selectedId): ?OrderSummaryRow
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

    private function resolveSelectedBillingRow(BillingMeterPage $page, ?string $selectedId): ?BillingMeterRow
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
