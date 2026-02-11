<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\DataGrid;

/**
 *
 */

/**
 *
 */
interface DataGridResultInterface
{
    /**
     * @return array
     */
    public function row(): array;

    /**
     * @return int
     */
    public function page(): int;

    /**
     * @return int
     */
    public function pageSize(): int;

    /**
     * @return int
     */
    public function total(): int;

    /**
     * @return bool
     */
    public function hasPrev(): bool;

    /**
     * @return bool
     */
    public function hasNext(): bool;
}
