<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Catalog\AttributeRegistry;

use App\Interfacing\CatalogInterface\AttributeRegistry\InterfaceActionCatalogInterface;
use App\Interfacing\EndpointInterface\AttributeRegistry\InterfaceActionEndpointInterface;

final class InterfaceActionCatalog implements InterfaceActionCatalogInterface
{
    /** @var array<string, array<string, InterfaceActionEndpointInterface>> */
    private array $action = [];

    public function add(InterfaceActionEndpointInterface $endpoint): void
    {
        $this->action[$endpoint->screenId()][$endpoint->actionId()] = $endpoint;
    }

    /**
     * @return array|InterfaceActionEndpointInterface[]
     */
    public function allForScreen(string $screenId): array
    {
        $list = array_values($this->action[$screenId] ?? []);
        usort($list, static function (InterfaceActionEndpointInterface $a, InterfaceActionEndpointInterface $b): int {
            return $a->order() <=> $b->order();
        });

        return $list;
    }

    public function get(string $screenId, string $actionId): InterfaceActionEndpointInterface
    {
        if (!isset($this->action[$screenId][$actionId])) {
            throw new \RuntimeException('Interfacing action not found: '.$screenId.':'.$actionId);
        }

        return $this->action[$screenId][$actionId];
    }
}
