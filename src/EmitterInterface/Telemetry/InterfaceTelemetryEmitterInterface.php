<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\EmitterInterface\Telemetry;

use App\Interfacing\Contract\Telemetry\InterfaceTelemetryEvent;

interface InterfaceTelemetryEmitterInterface
{
    public function emit(InterfaceTelemetryEvent $event): void;
}
