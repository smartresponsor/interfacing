<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\DataGrid;

/**
 *
 */

/**
 *
 */
final class DataGridResult
{
    /**
     * @param list<DataGridRow> $row
     */
    public function __construct(
        private readonly array $row,
        private readonly int   $page,
        private readonly int   $pageSize,
        private readonly int   $total,
    ) {
    }

    /**
     * @return list<DataGridRow>
     */
    public function row(): array
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * @return bool
     */
    public function hasPrev(): bool
    {
        return $this->page > 1;
    }

    /**
     * @return bool
     */
    public function hasNext(): bool
    {
        return ($this->page * $this->pageSize) < $this->total;
    }
}
