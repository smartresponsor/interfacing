<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\Metric;

interface InterfaceMetricProviderRegistryInterface
{
    public function has(string $id): bool;

    /**
     * @return \App\Interfacing\ProviderInterface\Widget\Metric\InterfaceMetricProviderInterface
     */
    public function get(string $id): InterfaceMetricProviderInterface;

    /**
     * @return list<string>
     */
    public function idList(): array;
}
