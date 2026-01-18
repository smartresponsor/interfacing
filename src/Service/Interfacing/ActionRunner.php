<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ActionRequest;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ActionResult;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\TelemetryEvent;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ActionId;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ScreenId;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\ActionCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\TelemetryBridgeInterface;

final class ActionRunner
{
    public function __construct(
        private ActionCatalogInterface $actionCatalog,
        private TelemetryBridgeInterface $telemetry
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
