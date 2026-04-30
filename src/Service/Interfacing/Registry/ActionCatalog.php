<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Service\Interfacing\Registry;

use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;

/**
 *
 */

/**
 *
 */
final class ActionCatalog implements ActionCatalogInterface
{
    /** @var array<string, array<string, ActionEndpointInterface>> */
    private array $action = [];

    /**
     * @param \App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface $endpoint
     * @return void
     */
    public function add(ActionEndpointInterface $endpoint): void
    {
        $this->action[$endpoint->screenId()][$endpoint->actionId()] = $endpoint;
    }

    /**
     * @param string $screenId
     * @return array|\App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface[]
     */
    public function allForScreen(string $screenId): array
    {
        $list = array_values($this->action[$screenId] ?? []);
        usort($list, static function (ActionEndpointInterface $a, ActionEndpointInterface $b): int {
            return $a->order() <=> $b->order();
        });
        return $list;
    }

    /**
     * @param string $screenId
     * @param string $actionId
     * @return \App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface
     */
    public function get(string $screenId, string $actionId): ActionEndpointInterface
    {
        if (!isset($this->action[$screenId][$actionId])) {
            throw new \RuntimeException('Interfacing action not found: ' . $screenId . ':' . $actionId);
        }
        return $this->action[$screenId][$actionId];
    }
}
