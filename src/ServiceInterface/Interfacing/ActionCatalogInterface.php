<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Catalog\ActionEndpointCatalogInterface;

/**
 * Deprecated compatibility alias for the canonical action endpoint catalog.
 *
 * New consumers must depend on Catalog\ActionEndpointCatalogInterface so the
 * endpoint catalog is not confused with Action\ActionCatalogInterface or the
 * screen-scoped Registry\ActionCatalogInterface.
 */
interface ActionCatalogInterface extends ActionEndpointCatalogInterface
{
}
