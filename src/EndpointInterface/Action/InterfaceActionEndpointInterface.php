<?php

declare(strict_types=1);

namespace App\Interfacing\EndpointInterface\Action;

use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Action\InterfaceActionRuntimeInterface;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;

interface InterfaceActionEndpointInterface
{
    public function id(): InterfaceActionId;

    /** @param array<string, mixed> $input */
    public function run(array $input, InterfaceActionRuntimeInterface $runtime): InterfaceActionResult;
}
