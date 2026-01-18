<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionIdInterface;

interface ActionCatalogInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function all(): array;

    public function has(ActionIdInterface $id): bool;

    public function get(ActionIdInterface $id): ActionEndpointInterface;
}

