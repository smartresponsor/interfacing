<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\DataGrid;

interface DataGridProviderRegistryInterface
{
    public function has(string $key): bool;

    public function get(string $key): DataGridProviderInterface;

    /**
     * @return list<string>
     */
    public function keyList(): array;
}
