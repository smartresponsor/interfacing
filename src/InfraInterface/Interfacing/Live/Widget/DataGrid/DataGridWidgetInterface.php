<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\InfraInterface\Interfacing\Live\Widget\DataGrid;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\DataGrid\DataGridResult;

interface DataGridWidgetInterface
{
    public function result(): DataGridResult;
}
