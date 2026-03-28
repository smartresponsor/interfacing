<?php

declare(strict_types=1);

namespace App\Service\Interfacing;

use App\Contract\Action\ActionRequest;
use App\Contract\Action\ActionResult;
use App\Contract\ValueObject\ActionId;
use App\Contract\ValueObject\ScreenId;
use App\ServiceInterface\Interfacing\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\TelemetryBridgeInterface;
use App\Support\Telemetry\TelemetryEvent;

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
