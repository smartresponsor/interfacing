<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\DataGrid;

interface DataGridColumnSpecInterface
{
    public function key(): string;

    public function title(): string;

    public function sortable(): bool;
}
