<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\DataGrid;

use App\Domain\Interfacing\Model\DataGrid\DataGridQuery;
use App\Domain\Interfacing\Model\DataGrid\DataGridResult;

/**
 *
 */

/**
 *
 */
interface DataGridProviderInterface
{
    /**
     * @return string
     */
    public function key(): string;

    /**
     * @param \App\Domain\Interfacing\Model\DataGrid\DataGridQuery $query
     * @param array $context
     * @return \App\Domain\Interfacing\Model\DataGrid\DataGridResult
     */
    public function fetch(DataGridQuery $query, array $context = []): DataGridResult;
}
