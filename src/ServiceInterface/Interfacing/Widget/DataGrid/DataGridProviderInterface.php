<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\DataGrid;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\DataGrid\DataGridQuery;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\DataGrid\DataGridResult;

interface DataGridProviderInterface
{
    public function key(): string;

    public function fetch(DataGridQuery $query, array $context = []): DataGridResult;
}
