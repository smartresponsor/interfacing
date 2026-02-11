<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\DataGrid;

use App\Domain\Interfacing\Model\DataGrid\DataGridResult;

/**
 *
 */

/**
 *
 */
interface DataGridWidgetInterface
{
    /**
     * @return \App\Domain\Interfacing\Model\DataGrid\DataGridResult
     */
    public function result(): DataGridResult;
}
