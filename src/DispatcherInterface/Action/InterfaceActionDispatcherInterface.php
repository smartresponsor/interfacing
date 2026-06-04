<?php

declare(strict_types=1);

namespace App\Interfacing\DispatcherInterface\Action;

use App\Interfacing\Contract\Runtime\InterfaceActionResult;

interface InterfaceActionDispatcherInterface
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $state
     */
    public function dispatch(string $screenId, string $actionId, array $payload, array $state): InterfaceActionResult;
}
