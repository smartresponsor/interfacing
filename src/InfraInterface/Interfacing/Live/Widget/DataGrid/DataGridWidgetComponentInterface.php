<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\DataGrid;

use App\Domain\Interfacing\Model\DataGrid\DataGridResult;

interface DataGridWidgetComponentInterface
{
    public function result(): DataGridResult;
}
