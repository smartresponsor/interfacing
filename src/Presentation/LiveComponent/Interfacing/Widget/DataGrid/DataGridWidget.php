<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Presentation\LiveComponent\Interfacing\Widget\DataGrid;

use App\Contract\View\DataGridQuery;
use App\Contract\View\DataGridResult;
use App\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_data_grid', template: 'interfacing/widget/data-grid/data-grid.html.twig')]
final class DataGridWidget implements DataGridWidgetInterface
{
    #[LiveProp]
    public string $providerKey = 'demo';

    #[LiveProp(writable: true)]
    public string $search = '';

    #[LiveProp(writable: true)]
    public int $pageIndex = 0;

    #[LiveProp(writable: true)]
    public int $pageSize = 20;

    #[LiveProp(writable: true)]
    public ?string $sortKey = null;

    #[LiveProp(writable: true)]
    public string $sortDir = 'asc';

    public function __construct(private readonly DataGridProviderRegistryInterface $registry)
    {
    }

    public function result(): DataGridResult
    {
        $query = new DataGridQuery(
            search: $this->search,
            sortKey: $this->sortKey ?? 'id',
            sortDir: $this->sortDir,
            page: max(1, $this->pageIndex + 1),
            pageSize: max(1, $this->pageSize),
        );

        $provider = $this->registry->get($this->providerKey);
        $res = $provider->fetch($query);

        $total = $res->total();
        if ($total > 0) {
            $maxPageIndex = intdiv(max(0, $total - 1), max(1, $this->pageSize));
            if ($this->pageIndex > $maxPageIndex) {
                $this->pageIndex = $maxPageIndex;
                $res = $provider->fetch(new DataGridQuery(
                    search: $this->search,
                    sortKey: $this->sortKey ?? 'id',
                    sortDir: $this->sortDir,
                    page: max(1, $this->pageIndex + 1),
                    pageSize: max(1, $this->pageSize),
                ));
            }
        }

        return $res;
    }

    #[LiveAction]
    public function setSearch(#[LiveArg] string $search): void
    {
        $this->search = $search;
        $this->pageIndex = 0;
    }

    #[LiveAction]
    public function setPageSize(#[LiveArg] int $pageSize): void
    {
        $this->pageSize = max(1, min(200, $pageSize));
        $this->pageIndex = 0;
    }

    #[LiveAction]
    public function sort(#[LiveArg] string $key): void
    {
        $key = trim($key);
        if ('' === $key) {
            return;
        }

        if ($this->sortKey === $key) {
            $this->sortDir = ('asc' === $this->sortDir) ? 'desc' : 'asc';
        } else {
            $this->sortKey = $key;
            $this->sortDir = 'asc';
        }

        $this->pageIndex = 0;
    }

    #[LiveAction]
    public function nextPage(): void
    {
        $this->pageIndex = max(0, $this->pageIndex + 1);
    }

    #[LiveAction]
    public function prevPage(): void
    {
        $this->pageIndex = max(0, $this->pageIndex - 1);
    }
}
