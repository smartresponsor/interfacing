<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Widget\Metric;

use App\ServiceInterface\Interfacing\Widget\Metric\MetricProviderInterface;
use App\ServiceInterface\Interfacing\Widget\Metric\MetricProviderRegistryInterface;

final class MetricProviderRegistry implements MetricProviderRegistryInterface
{
    /**
     * @var array<string,MetricProviderInterface>
     */
    private array $map = [];

    /**
     * @param iterable<MetricProviderInterface> $provider
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

    public function get(string $id): MetricProviderInterface
    {
        if (!isset($this->map[$id])) {
            throw new \InvalidArgumentException('Unknown metric provider: '.$id);
        }

        return $this->map[$id];
    }

    public function idList(): array
    {
        $id = array_keys($this->map);
        sort($id);
        return $id;
    }
}
