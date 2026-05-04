<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Catalog\ActionEndpointInterface as CatalogActionEndpointInterface;

/**
 * @deprecated Use Catalog\ActionEndpointInterface for bridge/simple action endpoints.
 */
interface ActionEndpointInterface extends CatalogActionEndpointInterface
{
}
