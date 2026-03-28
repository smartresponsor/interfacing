<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Action;

use App\Contract\Action\ActionResult;
use App\Contract\Action\ActionRuntimeInterface;
use App\Contract\ValueObject\ActionId;

interface ActionEndpointInterface
{
    public function id(): ActionId;

    /** @param array<string, mixed> $input */
    public function run(array $input, ActionRuntimeInterface $runtime): ActionResult;
}
