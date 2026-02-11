<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Value\ActionId;

/**
 *
 */

/**
 *
 */
interface ActionCatalogInterface
{
    /** @return list<ActionEndpointInterface> */
    public function all(): array;

    /**
     * @param \App\Domain\Interfacing\Value\ActionId $id
     * @return \App\ServiceInterface\Interfacing\ActionEndpointInterface
     */
    public function get(ActionId $id): ActionEndpointInterface;
}
