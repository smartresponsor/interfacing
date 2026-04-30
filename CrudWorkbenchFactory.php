<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudAction;
use App\Interfacing\Contract\Crud\CrudFilterField;
use App\Interfacing\Contract\Crud\CrudRouteContext;
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
    public function buildOrderSummaryView(OrderSummaryPage $page, array $filters, array $ctx, CrudRouteContext $routeContext): CrudWorkbenchView
    {
        $selectedRow = $this->resolveSelectedOrderRow($page, $routeContext->displayIdentifier());
        $currentQuery = array_filter([
            'status' => $filters['status'],
            'createdFrom' => $filters['createdFrom'],
            'createdTo' => $filters['createdTo'],
        ], static fn (mixed $value): bool => '' !== (string) $value);

        $rows = [];
        foreach ($page->items as $row) {
            $rows[] = [
                'id' => $row->id,
                'status' => $row->status,
                'createdAt' => $this->formatDateTime($row->createdAtIso),
                'amount' => number_format($row->totalGross, 2).' '.$row->currencyCode,
                'customer' => $row->customerEmail ?? 'guest',
                '_actions' => $this->rowActions($routeContext, $row->id),
            ];
        }

        return new CrudWorkbenchView(
            routeContext: $routeContext,
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
                'tenant: '.(string) ($ctx['tenantId'] ?? 'default'),
                'rows: '.$page->total,
            ],
            headerActions: $this->headerActions($routeContext, $currentQuery, $selectedRow?->id),
            panelTitle: 'CRUD command routing layer',
            panelHint: $routeContext->isAdminSurface() ? 'Admin surface keeps a denser command toolbar, destructive affordances, and '.strtolower($routeContext->resourceToneLabel()).'.' : 'Public surface keeps the same CRUD semantics but softens dangerous commands while preserving '.strtolower($routeContext->resourceToneLabel()).'.',
            panelMeta: sprintf('page %d · pageSize %d · %s · %s', $page->page, $page->pageSize, $routeContext->identifierKindLabel(), $routeContext->vocabularyLead()),
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
                    ],
                    note: 'This context matches the host CRUD endpoint pattern and is independent from the underlying entity type.',
                ),
                new CrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: [
                        'Request ref' => $selectedRow?->id,
                        'Workflow state' => $selectedRow?->status,
                        'Submitted at' => $selectedRow ? $this->formatDateTime($selectedRow->createdAtIso) : null,
                        'Gross total' => $selectedRow ? number_format($selectedRow->totalGross, 2).' '.$selectedRow->currencyCode : null,
                        'Customer email' => $selectedRow?->customerEmail ?? 'guest',
                    ],
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
                    actions: $this->commandActions($routeContext, $selectedRow?->id, $routeContext->adminSecondaryFormActionLabel()),
                ),
            ]),
        );
    }

    /**
     * @param array{status:string,periodFrom:string,periodTo:string} $filters
     * @param array<string, mixed> $ctx
     */
    public function buildBillingMeterView(BillingMeterPage $page, array $filters, array $ctx, CrudRouteContext $routeContext): CrudWorkbenchView
    {
        $selectedRow = $this->resolveSelectedBillingRow($page, $routeContext->displayIdentifier());
        $currentQuery = array_filter([
            'status' => $filters['status'],
            'periodFrom' => $filters['periodFrom'],
            'periodTo' => $filters['periodTo'],
        ], static fn (mixed $value): bool => '' !== (string) $value);

        $rows = [];
        foreach ($page->items as $row) {
            $rows[] = [
                'id' => $row->id,
                'status' => $row->status,
                'period' => $row->periodFromIso.' → '.$row->periodToIso,
                'amount' => '$'.number_format($row->amount, 2),
                '_actions' => $this->rowActions($routeContext, $row->id),
            ];
        }

        return new CrudWorkbenchView(
            routeContext: $routeContext,
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
                'tenant: '.(string) ($ctx['tenantId'] ?? 'default'),
                'rows: '.$page->total,
            ],
            headerActions: $this->headerActions($routeContext, $currentQuery, $selectedRow?->id),
            panelTitle: 'CRUD command routing layer',
            panelHint: $routeContext->isAdminSurface() ? 'Same center-body renderer with admin-grade command density and '.strtolower($routeContext->resourceToneLabel()).'.' : 'Same center-body renderer with public-safe presentation and lighter command density while preserving '.strtolower($routeContext->resourceToneLabel()).'.',
            panelMeta: sprintf('page %d · pageSize %d · %s · %s', $page->page, $page->pageSize, $routeContext->identifierKindLabel(), $routeContext->vocabularyLead()),
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
                    ],
                    note: 'Host-facing CRUD path semantics stay stable whether the resource is category, vendor, user, meter, or something else.',
                ),
                new CrudSidebarSection(
                    title: $routeContext->selectionSidebarTitle(),
                    facts: [
                        'Meter ref' => $selectedRow?->id,
                        'Reading state' => $selectedRow?->status,
                        'Reading window' => $selectedRow ? $selectedRow->periodFromIso.' → '.$selectedRow->periodToIso : null,
                        'Billed amount' => $selectedRow ? '$'.number_format($selectedRow->amount, 2) : null,
                    ],
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
                    actions: $this->commandActions($routeContext, $selectedRow?->id, 'Recalculate'),
                ),
            ]),
        );
    }

    /**
     * @return list<CrudAction>
     */
    private function headerActions(CrudRouteContext $routeContext, array $currentQuery, string|int|null $selectedIdentifier): array
    {
        return match ($routeContext->mode()) {
            'collection' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->createActionLabel(), $this->newHref($routeContext), 'primary'),
                    new CrudAction($routeContext->refreshActionLabel(), $this->indexHref($routeContext, $currentQuery)),
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $selectedIdentifier)),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier), 'danger'),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $currentQuery, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->createActionLabel(), $this->newHref($routeContext), 'primary'),
                    new CrudAction($routeContext->refreshActionLabel(), $this->indexHref($routeContext, $currentQuery)),
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $currentQuery, $selectedIdentifier)),
                ],
            'form' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->adminSecondaryFormActionLabel(), $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction('Cancel', $this->showHref($routeContext, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->publicPrimaryFormActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->publicSecondaryFormActionLabel(), $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction('Back', $this->showHref($routeContext, $selectedIdentifier)),
                ],
            'destructive' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier), 'danger'),
                    new CrudAction('Cancel', $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $currentQuery)),
                ]
                : [
                    new CrudAction($routeContext->publicDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier)),
                    new CrudAction('Back', $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $currentQuery)),
                ],
            default => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier), 'danger'),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $currentQuery)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $currentQuery, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->backToListActionLabel(), $this->indexHref($routeContext, $currentQuery)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, $currentQuery, $selectedIdentifier)),
                ],
        };
    }

    /**
     * @return list<CrudAction>
     */
    private function rowActions(CrudRouteContext $routeContext, string|int|null $identifier): array
    {
        return match ($routeContext->mode()) {
            'collection' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $identifier)),
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $identifier)),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $identifier), 'danger'),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $identifier)),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, [], $identifier)),
                ],
            'destructive' => [
                new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $identifier)),
            ],
            default => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $identifier)),
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $identifier)),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $identifier)),
                ],
        };
    }

    /**
     * @return list<CrudAction>
     */
    private function commandActions(CrudRouteContext $routeContext, string|int|null $selectedIdentifier, string $secondaryLabel): array
    {
        return match ($routeContext->mode()) {
            'form' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($secondaryLabel, $this->showHref($routeContext, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->publicPrimaryFormActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->publicSecondaryFormActionLabel(), $this->showHref($routeContext, $selectedIdentifier)),
                ],
            'destructive' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier), 'danger'),
                    new CrudAction('Cancel', $this->showHref($routeContext, $selectedIdentifier)),
                ]
                : [
                    new CrudAction($routeContext->publicDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier)),
                    new CrudAction('Back', $this->showHref($routeContext, $selectedIdentifier)),
                ],
            'detail' => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->editActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier), 'danger'),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($routeContext->nextActionLabel(), $this->nextHref($routeContext, [], $selectedIdentifier)),
                ],
            default => $routeContext->isAdminSurface()
                ? [
                    new CrudAction($routeContext->adminPrimaryFormActionLabel(), $this->editHref($routeContext, $selectedIdentifier), 'primary'),
                    new CrudAction($secondaryLabel, $this->showHref($routeContext, $selectedIdentifier)),
                    new CrudAction($routeContext->adminDestructiveActionLabel(), $this->deleteHref($routeContext, $selectedIdentifier), 'danger'),
                ]
                : [
                    new CrudAction($routeContext->showActionLabel(), $this->showHref($routeContext, $selectedIdentifier), 'primary'),
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

    private function indexHref(CrudRouteContext $routeContext, array $query = []): string
    {
        $base = '/'.trim($routeContext->resourcePath, '/').'/';

        return $this->appendQuery($base, $query);
    }

    private function newHref(CrudRouteContext $routeContext): string
    {
        return '/'.trim($routeContext->resourcePath, '/').'/new/';
    }

    private function showHref(CrudRouteContext $routeContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->indexHref($routeContext);
        }

        return '/'.trim($routeContext->resourcePath, '/').'/'.rawurlencode((string) $identifier);
    }

    private function editHref(CrudRouteContext $routeContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->newHref($routeContext);
        }

        return '/'.trim($routeContext->resourcePath, '/').'/edit/'.rawurlencode((string) $identifier);
    }

    private function deleteHref(CrudRouteContext $routeContext, string|int|null $identifier): string
    {
        if (null === $identifier || '' === (string) $identifier) {
            return $this->indexHref($routeContext);
        }

        return '/'.trim($routeContext->resourcePath, '/').'/delete/'.rawurlencode((string) $identifier);
    }

    private function nextHref(CrudRouteContext $routeContext, array $query, string|int|null $identifier): string
    {
        $query['selected'] = null === $identifier ? null : (string) $identifier;
        $query['step'] = 'next';

        return $this->appendQuery($this->showHref($routeContext, $identifier), array_filter($query, static fn (mixed $value): bool => null !== $value && '' !== (string) $value));
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
