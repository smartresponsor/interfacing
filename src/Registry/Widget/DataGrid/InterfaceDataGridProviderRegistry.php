<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Registry\Widget\DataGrid;

use App\Interfacing\ProviderInterface\Widget\DataGrid\InterfaceDataGridProviderInterface;
use App\Interfacing\RegistryInterface\Widget\DataGrid\InterfaceDataGridProviderRegistryInterface;

final class InterfaceDataGridProviderRegistry implements InterfaceDataGridProviderRegistryInterface
{
    /**
     * @var array<string,InterfaceDataGridProviderInterface>
     */
    private array $map = [];

    /**
     * @param iterable<InterfaceDataGridProviderInterface> $provider
     */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            $this->map[$p->key()] = $p;
        }
    }

    public function has(string $key): bool
    {
        return isset($this->map[$key]);
    }

    public function get(string $key): InterfaceDataGridProviderInterface
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
