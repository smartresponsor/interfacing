<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\DataGrid;

interface DataGridQueryInterface
{
    public function search(): string;

    public function sortKey(): string;

    public function sortDir(): string;

    public function page(): int;

    public function pageSize(): int;
}
