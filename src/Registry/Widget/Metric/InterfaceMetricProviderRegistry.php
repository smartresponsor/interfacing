<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Registry\Widget\Metric;

use App\Interfacing\ProviderInterface\Widget\Metric\InterfaceMetricProviderInterface;
use App\Interfacing\RegistryInterface\Widget\Metric\InterfaceMetricProviderRegistryInterface;

final class InterfaceMetricProviderRegistry implements InterfaceMetricProviderRegistryInterface
{
    /**
     * @var array<string,InterfaceMetricProviderInterface>
     */
    private array $map = [];

    /**
     * @param iterable<InterfaceMetricProviderInterface> $provider
     */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            $this->map[$p->id()] = $p;
        }
    }

    public function has(string $id): bool
    {
        return isset($this->map[$id]);
    }

    public function get(string $id): InterfaceMetricProviderInterface
    {
        if (!isset($this->map[$id])) {
            throw new \InvalidArgumentException('Unknown metric provider: '.$id);
        }

        return $this->map[$id];
    }

    /**
     * @return array|string[]
     */
    public function idList(): array
    {
        $id = array_keys($this->map);
        sort($id);

        return $id;
    }
}
