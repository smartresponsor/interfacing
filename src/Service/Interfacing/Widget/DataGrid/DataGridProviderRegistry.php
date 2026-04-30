<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Widget\DataGrid;

use App\Interfacing\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderRegistryInterface;

/**
 *
 */

/**
 *
 */
final class DataGridProviderRegistry implements DataGridProviderRegistryInterface
{
    /**
     * @var array<string,DataGridProviderInterface>
     */
    private array $map = [];

    /**
     * @param iterable<DataGridProviderInterface> $provider
     */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            $this->map[$p->key()] = $p;
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->map[$key]);
    }

    /**
     * @param string $key
     * @return \App\Interfacing\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderInterface
     */
    public function get(string $key): DataGridProviderInterface
    {
        if (!isset($this->map[$key])) {
            throw new \InvalidArgumentException('Unknown dataGrid provider: '.$key);
        }

        return $this->map[$key];
    }

    /**
     * @return array|string[]
     */
    public function keyList(): array
    {
        $keys = array_keys($this->map);
        sort($keys);

        return $keys;
    }
}
