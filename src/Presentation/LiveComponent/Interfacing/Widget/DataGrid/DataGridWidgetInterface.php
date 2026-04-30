<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Widget\DataGrid;

use App\Interfacing\Contract\View\DataGridResult;

interface DataGridWidgetInterface
{
    public function result(): DataGridResult;
}
