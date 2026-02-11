<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Value\ActionId;
use App\ServiceInterface\Interfacing\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\ActionEndpointInterface;

/**
 *
 */

/**
 *
 */
final class ActionCatalog implements ActionCatalogInterface
{
    /** @var list<ActionEndpointInterface> */
    private array $endpoint;
    /** @var array<string, ActionEndpointInterface>|null */
    private ?array $cache = null;

    /**
     * @param iterable $endpoint
     */
    public function __construct(iterable $endpoint)
    {
        $this->endpoint = [];
        foreach ($endpoint as $e) {
            if ($e instanceof ActionEndpointInterface) {
                $this->endpoint[] = $e;
            }
        }
    }

    /**
     * @return array|\App\ServiceInterface\Interfacing\ActionEndpointInterface[]
     */
    public function all(): array
    {
        return array_values($this->build());
    }

    /**
     * @param \App\Domain\Interfacing\Value\ActionId $id
     * @return \App\ServiceInterface\Interfacing\ActionEndpointInterface
     */
    public function get(ActionId $id): ActionEndpointInterface
    {
        $map = $this->build();
        $k = $id->toString();
        if (!isset($map[$k])) {
            throw new \RuntimeException('Unknown actionId: '.$k);
        }
        return $map[$k];
    }

    /** @return array<string, ActionEndpointInterface> */
    private function build(): array
    {
        if ($this->cache !== null) {
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
