<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\Metric;

use App\Interfacing\ProviderInterface\Widget\Metric\InterfaceMetricProviderInterface;

interface InterfaceMetricProviderRegistryInterface
{
    public function has(string $id): bool;

    public function get(string $id): InterfaceMetricProviderInterface;

    /**
     * @return list<string>
     */
    public function idList(): array;
}
