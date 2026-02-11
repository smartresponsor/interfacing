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
interface DataGridRowInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return array
     */
    public function cell(): array;
}
