<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\Contract\Action\ActionRequest;
use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\ValueObject\ActionId;

interface ActionEndpointInterface
{
    public function id(): ActionId;

    public function handle(ActionRequest $request): ActionResult;
}
