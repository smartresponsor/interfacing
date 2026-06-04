<?php

declare(strict_types=1);

namespace App\Interfacing\CatalogInterface;

use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\EndpointInterface\Catalog\InterfaceActionEndpointInterface;

/**
 * Canonical catalog contract for action endpoint contracts that execute by
 * InterfaceActionRequest/InterfaceActionResult and are consumed by doctor reports and action catalog code.
 *
 * Screen-scoped registry actions and modern action-runner endpoints intentionally
 * remain on their own Registry/Action contracts and must not be collapsed into
 * this catalog.
 */
interface InterfaceActionEndpointCatalogInterface
{
    /** @return list<InterfaceActionEndpointInterface> */
    public function all(): array;

    public function get(InterfaceActionId $id): InterfaceActionEndpointInterface;
}
