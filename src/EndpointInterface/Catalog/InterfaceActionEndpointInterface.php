<?php

declare(strict_types=1);

namespace App\Interfacing\EndpointInterface\Catalog;

use App\Interfacing\Contract\Action\InterfaceActionRequest;
use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;

/**
 * Canonical endpoint contract for action endpoints that execute through
 * InterfaceActionRequest/InterfaceActionResult and are cataloged by InterfaceActionEndpointCatalogInterface.
 *
 * Modern action-runner endpoints and screen-scoped registry endpoints must keep
 * using their own Action/ and Registry/ contracts.
 */
interface InterfaceActionEndpointInterface
{
    public function id(): InterfaceActionId;

    public function handle(InterfaceActionRequest $request): InterfaceActionResult;
}
