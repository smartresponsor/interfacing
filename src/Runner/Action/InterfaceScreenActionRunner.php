<?php

declare(strict_types=1);

namespace App\Interfacing\Runner\Action;

use App\Interfacing\CatalogInterface\InterfaceActionEndpointCatalogInterface;
use App\Interfacing\Contract\Action\InterfaceActionRequest;
use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Telemetry\InterfaceTelemetryEvent;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\EmitterInterface\Telemetry\InterfaceTelemetryEmitterInterface;

final class InterfaceScreenActionRunner
{
    public function __construct(
        private readonly InterfaceActionEndpointCatalogInterface $actionCatalog,
        private readonly InterfaceTelemetryEmitterInterface $telemetry,
    ) {
    }

    /** @param array<string, mixed> $payload @param array<string, mixed> $context */
    public function run(InterfaceScreenId $screenId, InterfaceActionId $actionId, array $payload, array $context): InterfaceActionResult
    {
        $t0 = microtime(true);
        try {
            return $this->actionCatalog->get($actionId)->handle(new InterfaceActionRequest($screenId, $actionId, $payload, $context));
        } finally {
            $dt = (microtime(true) - $t0) * 1000.0;
            $this->telemetry->emit(new InterfaceTelemetryEvent('action.run', [
                'screenId' => $screenId->toString(),
                'actionId' => $actionId->toString(),
            ], $dt));
        }
    }
}
