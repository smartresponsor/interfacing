<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Infra\Interfacing\Live\Widget\DataGrid;

use App\Domain\Interfacing\Model\DataGrid\DataGridQuery;
use App\Domain\Interfacing\Model\DataGrid\DataGridResult;
use App\InfraInterface\Interfacing\Live\Widget\DataGrid\DataGridWidgetInterface;
use App\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_data_grid', template: 'interfacing/widget/data-grid/data-grid.html.twig')]
final class DataGridWidget implements DataGridWidgetInterface
{
    #[LiveProp]
    public string $providerAlias = 'demo';

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

    public function __construct(private DataGridProviderRegistryInterface $registry)
    {
    }

    public function result(): DataGridResult
    {
        $query = new DataGridQuery(
            $this->search,
            $this->pageIndex,
            $this->pageSize,
            $this->sortKey,
            $this->sortDir,
        );

        $provider = $this->registry->get($this->providerAlias);
        $res = $provider->provide($query);

        $total = $res->itemTotal();
        if ($total !== null && $total > 0) {
            $maxPageIndex = intdiv(max(0, $total - 1), max(1, $this->pageSize));
            if ($this->pageIndex > $maxPageIndex) {
                $this->pageIndex = $maxPageIndex;
                $res = $provider->provide(new DataGridQuery(
                    $this->search,
                    $this->pageIndex,
                    $this->pageSize,
                    $this->sortKey,
                    $this->sortDir,
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
        if ($key === '') {
            return;
        }

        if ($this->sortKey === $key) {
            $this->sortDir = ($this->sortDir === 'asc') ? 'desc' : 'asc';
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
