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
interface DataGridColumnSpecInterface
{
    /**
     * @return string
     */
    public function key(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return bool
     */
    public function sortable(): bool;
}
