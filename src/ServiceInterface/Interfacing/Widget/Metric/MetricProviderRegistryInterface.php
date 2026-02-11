<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\Metric;

interface MetricProviderRegistryInterface
{
    public function has(string $id): bool;

    public function get(string $id): MetricProviderInterface;

    /**
     * @return list<string>
     */
    public function idList(): array;
}
