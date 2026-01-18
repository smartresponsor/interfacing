<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\ServiceInterface\Interfacing\Action;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\DomainInterface\Interfacing\Action\ActionIdInterface;

interface ActionCatalogInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function all(): array;

    public function has(ActionIdInterface $id): bool;

    public function get(ActionIdInterface $id): ActionEndpointInterface;
}

