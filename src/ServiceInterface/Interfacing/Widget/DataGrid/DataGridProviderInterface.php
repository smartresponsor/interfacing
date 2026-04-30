<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Widget\DataGrid;

use App\Interfacing\Contract\View\DataGridQuery;
use App\Interfacing\Contract\View\DataGridResult;

interface DataGridProviderInterface
{
    public function key(): string;

    public function fetch(DataGridQuery $query, array $context = []): DataGridResult;
}
