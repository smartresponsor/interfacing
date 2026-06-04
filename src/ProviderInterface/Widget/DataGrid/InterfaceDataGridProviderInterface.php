<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ProviderInterface\Widget\DataGrid;

use App\Interfacing\Contract\View\InterfaceDataGridQuery;
use App\Interfacing\Contract\View\InterfaceDataGridResult;

interface InterfaceDataGridProviderInterface
{
    public function key(): string;

    public function fetch(InterfaceDataGridQuery $query, array $context = []): InterfaceDataGridResult;
}
