<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\DataGrid;

interface InterfaceDataGridProviderRegistryInterface
{
    public function has(string $key): bool;

    /**
     * @return \App\Interfacing\ProviderInterface\Widget\DataGrid\InterfaceDataGridProviderInterface
     */
    public function get(string $key): InterfaceDataGridProviderInterface;

    /**
     * @return list<string>
     */
    public function keyList(): array;
}
