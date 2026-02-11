<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Interfacing\Action;

use App\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use App\DomainInterface\Interfacing\Action\ActionIdInterface;

interface ActionCatalogInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function all(): array;

    public function has(ActionIdInterface $id): bool;

    public function get(ActionIdInterface $id): ActionEndpointInterface;
}

