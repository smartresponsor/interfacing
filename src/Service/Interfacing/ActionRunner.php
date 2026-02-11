<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Model\ActionRequest;
use App\Domain\Interfacing\Model\ActionResult;
use App\Domain\Interfacing\Model\TelemetryEvent;
use App\Domain\Interfacing\Value\ActionId;
use App\Domain\Interfacing\Value\ScreenId;
use App\ServiceInterface\Interfacing\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\TelemetryBridgeInterface;

/**
 *
 */

/**
 *
 */
final class ActionRunner
{
    /**
     * @param \App\ServiceInterface\Interfacing\ActionCatalogInterface $actionCatalog
     * @param \App\ServiceInterface\Interfacing\TelemetryBridgeInterface $telemetry
     */
    public function __construct(
        private readonly ActionCatalogInterface   $actionCatalog,
        private readonly TelemetryBridgeInterface $telemetry
    ) {}

    /** @param array<string,mixed> $payload @param array<string,mixed> $context */
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
