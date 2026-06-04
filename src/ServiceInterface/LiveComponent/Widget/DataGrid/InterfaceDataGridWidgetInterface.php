<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\LiveComponent\Widget\DataGrid;

use App\Interfacing\Contract\View\InterfaceDataGridResult;

interface InterfaceDataGridWidgetInterface
{
    public function result(): InterfaceDataGridResult;
}
