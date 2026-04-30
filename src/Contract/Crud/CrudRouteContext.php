<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * Host-aligned CRUD route semantics extracted from request attributes.
 *
 * The rendering layer should react to these semantics rather than to any
 * specific entity name. This keeps Interfacing reusable across resources.
 *
 * @psalm-immutable
 */
final readonly class CrudRouteContext
{
    public function __construct(
        public string $resourcePath,
        public string $operation,
        public string $surface,
        public ?string $identifierField = null,
        public string|int|null $identifierValue = null,
    ) {
    }

    public function mode(): string
    {
        return match ($this->operation) {
            'index' => 'collection',
            'new', 'edit' => 'form',
            'delete' => 'destructive',
            default => 'detail',
        };
    }

    public function isAdminSurface(): bool
    {
        return 'admin' === $this->surface;
    }

    public function isPublicSurface(): bool
    {
        return 'public' === $this->surface;
    }

    public function surfaceLabel(): string
    {
        return $this->isAdminSurface() ? 'Operational admin surface' : 'Consumer-safe public surface';
    }

    public function displayIdentifier(): ?string
    {
        if (null === $this->identifierValue) {
            return null;
        }

        return (string) $this->identifierValue;
    }

    public function identifierKindLabel(): string
    {
        return match ($this->identifierField) {
            'slug' => 'SEO/public slug addressing',
            'id' => 'Operator/internal id addressing',
            default => 'Collection scope without identifier',
        };
    }

    /**
     * @return list<string>
     */
    public function resourceSegments(): array
    {
        return array_values(array_filter(explode('/', trim($this->resourcePath, '/')), static fn (string $segment): bool => '' !== $segment));
    }

    public function resourceLabel(): string
    {
        return [] === $this->resourceSegments() ? 'Resource' : implode(' / ', $this->resourceSegmentLabels());
    }

    public function resourceDomainLabel(): string
    {
        return $this->resourceSegmentLabels()[0] ?? 'Resource';
    }

    public function resourceEntityLabel(): string
    {
        $labels = $this->resourceSegmentLabels();

        return $labels[array_key_last($labels)] ?? 'Record';
    }

    public function resourceCollectionLabel(): string
    {
        $entity = $this->resourceEntityLabel();

        return match (true) {
            str_ends_with($entity, 's') => $entity,
            str_ends_with($entity, 'y') => substr($entity, 0, -1).'ies',
            default => $entity.'s',
        };
    }

    public function resourceToneLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Transaction and request lifecycle copy',
            'meter' => 'Reading and measurement lifecycle copy',
            default => 'Neutral reusable CRUD copy',
        };
    }

    public function createActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Create order',
            'meter' => 'Register meter',
            default => 'Create '.$this->resourceEntityLabel(),
        };
    }

    public function refreshActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Refresh orders',
            'meter' => 'Refresh meters',
            default => 'Refresh '.$this->resourceCollectionLabel(),
        };
    }

    public function showActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Open order',
            'meter' => 'Open meter',
            default => 'Open '.$this->resourceEntityLabel(),
        };
    }

    public function editActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Edit order',
            'meter' => 'Adjust meter',
            default => 'Edit '.$this->resourceEntityLabel(),
        };
    }

    public function nextActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Next order step',
            'meter' => 'Next reading step',
            default => 'Next',
        };
    }

    public function adminDestructiveActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Cancel order',
            'meter' => 'Retire meter',
            default => 'Delete '.$this->resourceEntityLabel(),
        };
    }

    public function publicDestructiveActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Request cancellation',
            'meter' => 'Archive request',
            default => 'Archive request',
        };
    }

    public function adminPrimaryFormActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Save order',
            'meter' => 'Save meter',
            default => 'Save '.$this->resourceEntityLabel(),
        };
    }

    public function adminSecondaryFormActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Save order draft',
            'meter' => 'Save reading draft',
            default => 'Save draft',
        };
    }

    public function publicPrimaryFormActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Submit order update',
            'meter' => 'Submit meter change',
            default => 'Submit',
        };
    }

    public function publicSecondaryFormActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Preview order',
            'meter' => 'Preview reading',
            default => 'Preview',
        };
    }

    public function backToListActionLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Back to orders',
            'meter' => 'Back to meters',
            default => 'Back to list',
        };
    }


    public function statusFilterLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Workflow state',
            'meter' => 'Reading state',
            default => 'Status',
        };
    }

    public function dateFromFilterLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Submitted from',
            'meter' => 'Window from',
            default => 'Date from',
        };
    }

    public function dateToFilterLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Submitted to',
            'meter' => 'Window to',
            default => 'Date to',
        };
    }

    public function statusFilterPlaceholder(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Filter by request lifecycle state',
            'meter' => 'Filter by reading lifecycle state',
            default => 'Filter by state',
        };
    }

    public function fromFilterPlaceholder(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Earliest submitted date',
            'meter' => 'Earliest reading window date',
            default => 'Start date',
        };
    }

    public function toFilterPlaceholder(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Latest submitted date',
            'meter' => 'Latest reading window date',
            default => 'End date',
        };
    }

    /**
     * @return list<array{value:string,label:string}>
     */
    public function statusFilterOptions(): array
    {
        return match ($this->resourceKey()) {
            'order' => [
                ['value' => '', 'label' => 'All request states'],
                ['value' => 'paid', 'label' => 'Paid / confirmed'],
                ['value' => 'pending', 'label' => 'Pending review'],
                ['value' => 'failed', 'label' => 'Failed / blocked'],
            ],
            'meter' => [
                ['value' => '', 'label' => 'All reading states'],
                ['value' => 'active', 'label' => 'Active reading'],
                ['value' => 'closed', 'label' => 'Closed cycle'],
                ['value' => 'failed', 'label' => 'Failed reconciliation'],
            ],
            default => [
                ['value' => '', 'label' => 'All states'],
            ],
        };
    }

    public function identifierColumnLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Request ref',
            'meter' => 'Meter ref',
            default => $this->resourceEntityLabel(),
        };
    }

    public function statusColumnLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Workflow state',
            'meter' => 'Reading state',
            default => 'Status',
        };
    }

    public function primaryDateColumnLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Submitted at',
            'meter' => 'Reading window',
            default => 'Date',
        };
    }

    public function amountColumnLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Gross total',
            'meter' => 'Billed amount',
            default => 'Amount',
        };
    }

    public function auxiliaryColumnLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Customer email',
            'meter' => 'Settlement state',
            default => 'Details',
        };
    }



    /**
     * @return array<string, scalar|null>
     */
    public function rowDetailFacts(array $row): array
    {
        return match ($this->resourceKey()) {
            'order' => [
                'Request ref' => $row['id'] ?? null,
                'Workflow state' => $row['status'] ?? null,
                'Submitted at' => $row['createdAt'] ?? null,
                'Gross total' => $row['amount'] ?? null,
                'Customer email' => $row['customer'] ?? 'guest',
            ],
            'meter' => [
                'Meter ref' => $row['id'] ?? null,
                'Reading state' => $row['status'] ?? null,
                'Reading window' => $row['period'] ?? null,
                'Billed amount' => $row['amount'] ?? null,
                'Settlement state' => $row['settlement'] ?? 'pending reconciliation',
            ],
            default => [
                'Record ref' => $row['id'] ?? null,
                'Status' => $row['status'] ?? null,
            ],
        };
    }

    /**
     * @return list<array{name:string,label:string,type:string,placeholder:string,helpText:string,value:string,options:list<array{value:string,label:string}>}>
     */
    public function formFieldBlueprints(array $facts): array
    {
        return match ($this->resourceKey()) {
            'order' => [
                ['name' => 'requestRef', 'label' => 'Request ref', 'type' => 'text', 'placeholder' => 'Generated request reference', 'helpText' => 'Internal reference for order routing.', 'value' => (string) ($facts['Request ref'] ?? ''), 'options' => []],
                ['name' => 'workflowState', 'label' => 'Workflow state', 'type' => 'select', 'placeholder' => '', 'helpText' => 'Lifecycle state for the current request.', 'value' => (string) ($facts['Workflow state'] ?? ''), 'options' => $this->statusFilterOptions()],
                ['name' => 'submittedAt', 'label' => 'Submitted at', 'type' => 'text', 'placeholder' => 'ISO submission timestamp', 'helpText' => 'Inbound request timestamp from the host CRUD flow.', 'value' => (string) ($facts['Submitted at'] ?? ''), 'options' => []],
                ['name' => 'grossTotal', 'label' => 'Gross total', 'type' => 'text', 'placeholder' => '0.00 USD', 'helpText' => 'Gross request amount used by the order flow.', 'value' => (string) ($facts['Gross total'] ?? ''), 'options' => []],
                ['name' => 'customerEmail', 'label' => 'Customer email', 'type' => 'email', 'placeholder' => 'customer@example.test', 'helpText' => 'Primary customer contact bound to this request.', 'value' => (string) ($facts['Customer email'] ?? ''), 'options' => []],
            ],
            'meter' => [
                ['name' => 'meterRef', 'label' => 'Meter ref', 'type' => 'text', 'placeholder' => 'Generated meter reference', 'helpText' => 'Internal reference for the billing meter surface.', 'value' => (string) ($facts['Meter ref'] ?? ''), 'options' => []],
                ['name' => 'readingState', 'label' => 'Reading state', 'type' => 'select', 'placeholder' => '', 'helpText' => 'Operational state for the reading cycle.', 'value' => (string) ($facts['Reading state'] ?? ''), 'options' => $this->statusFilterOptions()],
                ['name' => 'readingWindow', 'label' => 'Reading window', 'type' => 'text', 'placeholder' => '2026-04-01 → 2026-04-30', 'helpText' => 'Window used to reconcile the measurement cycle.', 'value' => (string) ($facts['Reading window'] ?? ''), 'options' => []],
                ['name' => 'billedAmount', 'label' => 'Billed amount', 'type' => 'text', 'placeholder' => '$0.00', 'helpText' => 'Amount scheduled for settlement after reconciliation.', 'value' => (string) ($facts['Billed amount'] ?? ''), 'options' => []],
                ['name' => 'settlementState', 'label' => 'Settlement state', 'type' => 'text', 'placeholder' => 'pending reconciliation', 'helpText' => 'Downstream settlement marker for the current reading.', 'value' => (string) ($facts['Settlement state'] ?? ''), 'options' => []],
            ],
            default => [
                ['name' => 'recordRef', 'label' => 'Record ref', 'type' => 'text', 'placeholder' => 'Record reference', 'helpText' => 'Reusable identifier field.', 'value' => (string) ($facts['Record ref'] ?? ''), 'options' => []],
                ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'placeholder' => 'status', 'helpText' => 'Reusable lifecycle field.', 'value' => (string) ($facts['Status'] ?? ''), 'options' => []],
            ],
        };
    }

    /**
     * @return list<array{title:string,description:string,fieldNames:list<string>}>
     */
    public function formSectionBlueprints(): array
    {
        return match ($this->resourceKey()) {
            'order' => [
                ['title' => 'Request identity', 'description' => 'Internal/admin identity fields and routing anchors for the request.', 'fieldNames' => ['requestRef', 'customerEmail']],
                ['title' => 'Workflow and intake', 'description' => 'Lifecycle state and intake timing for the current order request.', 'fieldNames' => ['workflowState', 'submittedAt']],
                ['title' => 'Commercial context', 'description' => 'Commercial amount and submission-readiness checks for the order.', 'fieldNames' => ['grossTotal']],
            ],
            'meter' => [
                ['title' => 'Meter identity', 'description' => 'Internal/admin identity fields for the meter workbench surface.', 'fieldNames' => ['meterRef', 'settlementState']],
                ['title' => 'Reading cycle', 'description' => 'Operational reading-cycle state and window reconciliation inputs.', 'fieldNames' => ['readingState', 'readingWindow']],
                ['title' => 'Settlement context', 'description' => 'Billing amount and settlement-readiness checks for the reading.', 'fieldNames' => ['billedAmount']],
            ],
            default => [
                ['title' => 'Record details', 'description' => 'Reusable CRUD identity and lifecycle fields.', 'fieldNames' => ['recordRef', 'status']],
            ],
        };
    }

    /**
     * @return list<string>
     */
    public function requiredFieldNames(): array
    {
        return match ($this->resourceKey()) {
            'order' => ['requestRef', 'workflowState', 'grossTotal', 'customerEmail'],
            'meter' => ['meterRef', 'readingState', 'readingWindow', 'billedAmount'],
            default => ['recordRef', 'status'],
        };
    }

    /**
     * @return list<string>
     */
    public function warningFieldNames(): array
    {
        return match ($this->resourceKey()) {
            'order' => ['submittedAt'],
            'meter' => ['settlementState'],
            default => [],
        };
    }

    public function requiredFieldMessage(string $fieldName): string
    {
        return match ($fieldName) {
            'customerEmail' => 'A contact email is required before the request can move forward.',
            'grossTotal' => 'A gross total is required for transactional review.',
            'billedAmount' => 'A billed amount is required before settlement routing.',
            default => 'This field is required before the CRUD command can be completed.',
        };
    }

    public function warningFieldMessage(string $fieldName, string $value): string
    {
        return match ($fieldName) {
            'submittedAt' => 'Review the inbound submission timestamp before confirming workflow changes.',
            'settlementState' => 'Settlement remains informational here; downstream reconciliation may still update it.',
            default => '' === $value ? '' : 'Review this field before continuing.',
        };
    }

    public function formValidationSummaryLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Order form schema is grouped and all required request fields are currently satisfied.',
            'meter' => 'Meter form schema is grouped and the current reading fields are ready for review.',
            default => 'Grouped CRUD form schema is currently valid.',
        };
    }

    public function vocabularyLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Transaction-safe request vocabulary for filters, columns, and command forms.',
            'meter' => 'Measurement-safe vocabulary for readings, windows, and settlement cues.',
            default => 'Neutral reusable vocabulary for shared CRUD rendering.',
        };
    }

    public function emptyStateLabel(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'No orders match the active request filters yet.',
            'meter' => 'No meter readings match the active window filters yet.',
            default => 'No records match the active filter set.',
        };
    }

    public function paginationLabel(int $visibleCount, int $totalCount): string
    {
        return match ($this->resourceKey()) {
            'order' => sprintf('Showing %d of %d orders in the current request window', $visibleCount, $totalCount),
            'meter' => sprintf('Showing %d of %d meter readings in the current operational window', $visibleCount, $totalCount),
            default => sprintf('Showing %d of %d records', $visibleCount, $totalCount),
        };
    }

    public function selectionSidebarTitle(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Selected order',
            'meter' => 'Selected meter',
            default => 'Selected record',
        };
    }

    public function destructiveSidebarTitle(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Cancellation target',
            'meter' => 'Retirement target',
            default => 'Deletion target',
        };
    }

    public function routeContextSidebarTitle(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Request route context',
            'meter' => 'Reading route context',
            default => 'Route context',
        };
    }

    public function commandSidebarTitle(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Order command form',
            'meter' => 'Reading command form',
            default => 'Command form',
        };
    }

    public function emptyStateLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Order collection stays ready for the next request intake once filters widen or new requests arrive.',
            'meter' => 'Meter collection stays ready for the next reading cycle once the operational window or state filter changes.',
            default => 'The shared CRUD collection stays ready for the next matching record set.',
        };
    }

    public function collectionModeLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Collection mode focuses on order intake, status monitoring, and request handling.',
            'meter' => 'Collection mode focuses on meter inventory, reading state, and operational follow-up.',
            default => 'Collection mode focuses on shared listing, filtering, and row-level command handling.',
        };
    }

    public function detailModeLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Detail mode emphasizes order lifecycle facts and the current request context.',
            'meter' => 'Detail mode emphasizes reading state, meter activity, and operational context.',
            default => 'Detail mode emphasizes entity facts and contextual read-side review.',
        };
    }

    public function formModeLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Form mode centers order edits and request-safe command submission.',
            'meter' => 'Form mode centers measurement edits and meter-safe command submission.',
            default => 'Form mode centers reusable CRUD editing and command submission.',
        };
    }

    public function destructiveModeLead(): string
    {
        return match ($this->resourceKey()) {
            'order' => 'Destructive mode protects order cancellation and request withdrawal flows.',
            'meter' => 'Destructive mode protects meter retirement and archive flows.',
            default => 'Destructive mode protects reusable removal and archive flows.',
        };
    }

    /**
     * @return list<string>
     */
    public function breadcrumbItems(): array
    {
        $breadcrumbs = ['CRUD'];

        foreach ($this->resourceSegmentLabels() as $label) {
            $breadcrumbs[] = $label;
        }

        $breadcrumbs[] = ucfirst($this->operation);

        if (null !== $this->displayIdentifier()) {
            $breadcrumbs[] = (string) $this->displayIdentifier();
        }

        return $breadcrumbs;
    }

    /**
     * @return list<string>
     */
    private function resourceSegmentLabels(): array
    {
        return array_map(static function (string $segment): string {
            $normalized = str_replace(['-', '_'], ' ', $segment);

            return ucfirst($normalized);
        }, $this->resourceSegments());
    }

    private function resourceKey(): string
    {
        $segments = $this->resourceSegments();

        return $segments[array_key_last($segments)] ?? 'resource';
    }
}
