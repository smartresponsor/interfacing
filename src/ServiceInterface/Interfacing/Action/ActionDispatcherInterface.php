<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Action;

use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;

interface ActionDispatcherInterface
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $state
     */
    public function dispatch(string $screenId, string $actionId, array $payload, array $state): ActionResult;
}
