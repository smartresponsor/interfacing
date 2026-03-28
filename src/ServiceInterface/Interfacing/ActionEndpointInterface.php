<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing;

use App\Contract\Action\ActionRequest;
use App\Contract\Action\ActionResult;
use App\Contract\ValueObject\ActionId;

interface ActionEndpointInterface
{
    public function id(): ActionId;

    public function handle(ActionRequest $request): ActionResult;
}
