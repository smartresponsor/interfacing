<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Catalog;

use App\Interfacing\Contract\Action\ActionRequest;
use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\ValueObject\ActionId;

/**
 * Canonical endpoint contract for bridge/simple actions that execute through
 * ActionRequest/ActionResult and are cataloged by ActionEndpointCatalogInterface.
 *
 * Modern action-runner endpoints and screen-scoped registry endpoints must keep
 * using their own Action/ and Registry/ contracts.
 */
interface ActionEndpointInterface
{
    public function id(): ActionId;

    public function handle(ActionRequest $request): ActionResult;
}
