<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Widget\DataGrid;

use App\Contract\View\DataGridQuery;
use App\Contract\View\DataGridResult;

interface DataGridProviderInterface
{
    public function key(): string;

    public function fetch(DataGridQuery $query, array $context = []): DataGridResult;
}
