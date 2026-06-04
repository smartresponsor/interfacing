<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Catalog;

use App\Interfacing\CatalogInterface\InterfaceActionEndpointCatalogInterface;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\EndpointInterface\Catalog\InterfaceActionEndpointInterface;

final class InterfaceActionEndpointCatalog implements InterfaceActionEndpointCatalogInterface
{
    /** @var list<InterfaceActionEndpointInterface> */
    private array $endpoint;
    /** @var array<string, InterfaceActionEndpointInterface>|null */
    private ?array $cache = null;

    public function __construct(iterable $endpoint)
    {
        $this->endpoint = [];
        foreach ($endpoint as $e) {
            if ($e instanceof InterfaceActionEndpointInterface) {
                $this->endpoint[] = $e;
            }
        }
    }

    /**
     * @return array|InterfaceActionEndpointInterface[]
     */
    public function all(): array
    {
        return array_values($this->build());
    }

    public function get(InterfaceActionId $id): InterfaceActionEndpointInterface
    {
        $map = $this->build();
        $k = $id->toString();
        if (!isset($map[$k])) {
            throw new \RuntimeException('Unknown actionId: '.$k);
        }

        return $map[$k];
    }

    /** @return array<string, InterfaceActionEndpointInterface> */
    private function build(): array
    {
        if (null !== $this->cache) {
            return $this->cache;
        }
        $map = [];
        foreach ($this->endpoint as $e) {
            $map[$e->id()->toString()] = $e;
        }
        ksort($map);
        $this->cache = $map;

        return $map;
    }
}
