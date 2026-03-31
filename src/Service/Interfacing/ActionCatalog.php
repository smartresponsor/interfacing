<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Contract\ValueObject\ActionId;
use App\ServiceInterface\Interfacing\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\ActionEndpointInterface;

final class ActionCatalog implements ActionCatalogInterface
{
    /** @var list<ActionEndpointInterface> */
    private array $endpoint;
    /** @var array<string, ActionEndpointInterface>|null */
    private ?array $cache = null;

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
     * @return array|ActionEndpointInterface[]
     */
    public function all(): array
    {
        return array_values($this->build());
    }

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
