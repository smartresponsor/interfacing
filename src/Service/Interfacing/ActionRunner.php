<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\Contract\Action\ActionRequest;
use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\ServiceInterface\Interfacing\ActionCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\TelemetryBridgeInterface;
use App\Interfacing\Support\Telemetry\TelemetryEvent;

final class ActionRunner
{
    public function __construct(
        private readonly ActionCatalogInterface $actionCatalog,
        private readonly TelemetryBridgeInterface $telemetry,
    ) {
    }

    /** @param array<string, mixed> $payload @param array<string, mixed> $context */
    public function run(ScreenId $screenId, ActionId $actionId, array $payload, array $context): ActionResult
    {
        $t0 = microtime(true);
        try {
            return $this->actionCatalog->get($actionId)->handle(new ActionRequest($screenId, $actionId, $payload, $context));
        } finally {
            $dt = (microtime(true) - $t0) * 1000.0;
            $this->telemetry->emit(new TelemetryEvent('action.run', [
                'screenId' => $screenId->toString(),
                'actionId' => $actionId->toString(),
            ], $dt));
        }
    }
}
