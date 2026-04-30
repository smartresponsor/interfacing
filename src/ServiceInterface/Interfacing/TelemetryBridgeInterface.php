<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\Support\Telemetry\TelemetryEvent;

interface TelemetryBridgeInterface
{
    public function emit(TelemetryEvent $event): void;
}
