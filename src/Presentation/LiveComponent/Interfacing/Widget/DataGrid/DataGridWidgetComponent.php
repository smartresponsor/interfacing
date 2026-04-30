<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Widget\DataGrid;

use App\Interfacing\Contract\Dto\BulkActionResult;
use App\Interfacing\Contract\View\DataGridQuery;
use App\Interfacing\Contract\View\DataGridResult;
use App\Interfacing\ServiceInterface\Interfacing\Widget\BulkAction\BulkActionRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_data_grid', template: 'interfacing/widget/data-grid/data-grid.html.twig')]
final class DataGridWidgetComponent implements DataGridWidgetComponentInterface
{
    #[LiveProp]
    public string $providerKey = 'demo';

    #[LiveProp(writable: true)]
    public string $search = '';

    #[LiveProp(writable: true)]
    public string $sortKey = 'id';

    #[LiveProp(writable: true)]
    public string $sortDir = 'asc';

    #[LiveProp(writable: true)]
    public int $page = 1;

    #[LiveProp(writable: true)]
    public int $pageSize = 10;

    #[LiveProp(writable: true)]
    public array $selectedId = [];

    #[LiveProp(writable: true)]
    public string $bulkActionId = 'demo-mark-done';

    #[LiveProp(writable: true)]
    public array $removedId = [];

    #[LiveProp(writable: true)]
    public array $doneId = [];

    #[LiveProp(writable: true)]
    public string $flash = '';

    #[LiveProp]
    public array $context = [];

    public function __construct(
        private readonly DataGridProviderRegistryInterface $registry,
        private readonly BulkActionRegistryInterface $bulkRegistry,
    ) {
    }

    public function __invoke(): void
    {
    }

    public function result(): DataGridResult
    {
        $query = new DataGridQuery(
            search: $this->search,
            sortKey: $this->sortKey,
            sortDir: $this->sortDir,
            page: $this->page,
            pageSize: $this->pageSize,
        );

        $result = $this->registry->get($this->providerKey)->fetch($query, $this->context);

        if ([] !== $this->removedId) {
            $row = array_values(array_filter($result->row(), function ($row): bool {
                return !in_array($row->id(), $this->removedId, true);
            }));
            $result = new DataGridResult($row, $result->page(), $result->pageSize(), max(0, $result->total() - count($this->removedId)));
        }

        return $result;
    }

    public function bulkActionList(): array
    {
        return $this->bulkRegistry->list();
    }

    public function isSelected(string $id): bool
    {
        return in_array($id, $this->selectedId, true);
    }

    public function isDone(string $id): bool
    {
        return in_array($id, $this->doneId, true);
    }

    #[LiveAction]
    public function next(): void
    {
        ++$this->page;
    }

    #[LiveAction]
    public function prev(): void
    {
        $this->page = max(1, $this->page - 1);
    }

    #[LiveAction]
    public function setSort(string $key): void
    {
        if ($this->sortKey === $key) {
            $this->sortDir = ('asc' === $this->sortDir) ? 'desc' : 'asc';
        } else {
            $this->sortKey = $key;
            $this->sortDir = 'asc';
        }
        $this->page = 1;
    }

    #[LiveAction]
    public function clearSearch(): void
    {
        $this->search = '';
        $this->page = 1;
    }

    #[LiveAction]
    public function toggleSelect(string $id): void
    {
        if ('' === $id) {
            return;
        }

        if ($this->isSelected($id)) {
            $this->selectedId = array_values(array_filter($this->selectedId, static fn (string $x): bool => $x !== $id));

            return;
        }

        $this->selectedId[] = $id;
        $this->selectedId = array_values(array_unique($this->selectedId));
    }

    #[LiveAction]
    public function clearSelect(): void
    {
        $this->selectedId = [];
    }

    #[LiveAction]
    public function selectPage(): void
    {
        $id = [];
        foreach ($this->result()->row() as $row) {
            $id[] = $row->id();
        }
        $this->selectedId = array_values(array_unique(array_merge($this->selectedId, $id)));
    }

    #[LiveAction]
    public function runBulk(): void
    {
        $id = array_values(array_unique(array_filter($this->selectedId, static fn ($x): bool => is_string($x) && '' !== $x)));
        if ([] === $id) {
            $this->flash = 'Select at least one item.';

            return;
        }

        $handler = $this->bulkRegistry->handler($this->bulkActionId);
        $result = $handler->execute($id, $this->context);

        $this->applyBulkResult($result);
    }

    private function applyBulkResult(BulkActionResult $result): void
    {
        $this->flash = $result->message();

        if ([] !== $result->removedId()) {
            $this->removedId = array_values(array_unique(array_merge($this->removedId, $result->removedId())));
            $this->selectedId = array_values(array_filter($this->selectedId, fn (string $x): bool => !in_array($x, $this->removedId, true)));
        }

        if ([] !== $result->updatedId()) {
            $this->doneId = array_values(array_unique(array_merge($this->doneId, $result->updatedId())));
        }
    }
}
