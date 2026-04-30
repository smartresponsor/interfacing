<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Widget\Metric;

/**
 *
 */

/**
 *
 */
interface MetricProviderRegistryInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool;

    /**
     * @param string $id
     * @return \App\Interfacing\ServiceInterface\Interfacing\Widget\Metric\MetricProviderInterface
     */
    public function get(string $id): MetricProviderInterface;

    /**
     * @return list<string>
     */
    public function idList(): array;
}
