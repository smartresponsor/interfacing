<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Action;

use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\Action\ActionRuntimeInterface;
use App\Interfacing\Contract\ValueObject\ActionId;

interface ActionEndpointInterface
{
    public function id(): ActionId;

    /** @param array<string, mixed> $input */
    public function run(array $input, ActionRuntimeInterface $runtime): ActionResult;
}
