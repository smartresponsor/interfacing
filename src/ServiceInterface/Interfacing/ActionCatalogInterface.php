<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Contract\ValueObject\ActionId;

interface ActionCatalogInterface
{
    /** @return list<ActionEndpointInterface> */
    public function all(): array;

    public function get(ActionId $id): ActionEndpointInterface;
}
