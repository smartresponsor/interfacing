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
interface DataGridQueryInterface
{
    /**
     * @return string
     */
    public function search(): string;

    /**
     * @return string
     */
    public function sortKey(): string;

    /**
     * @return string
     */
    public function sortDir(): string;

    /**
     * @return int
     */
    public function page(): int;

    /**
     * @return int
     */
    public function pageSize(): int;
}
