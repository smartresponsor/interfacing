<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Catalog;

use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\ServiceInterface\Interfacing\Catalog\ActionEndpointInterface;

/**
 * Canonical catalog contract for bridge/simple action endpoints that execute by
 * ActionRequest/ActionResult and are consumed by doctor reports and bridge code.
 *
 * Screen-scoped registry actions and modern action-runner endpoints intentionally
 * remain on their own Registry/Action contracts and must not be collapsed into
 * this catalog.
 */
interface ActionEndpointCatalogInterface
{
    /** @return list<ActionEndpointInterface> */
    public function all(): array;

    public function get(ActionId $id): ActionEndpointInterface;
}
