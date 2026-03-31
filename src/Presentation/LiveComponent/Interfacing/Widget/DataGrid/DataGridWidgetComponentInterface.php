<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\LiveComponent\Interfacing\Widget\DataGrid;

use App\Contract\View\DataGridResult;

interface DataGridWidgetComponentInterface
{
    public function result(): DataGridResult;
}
