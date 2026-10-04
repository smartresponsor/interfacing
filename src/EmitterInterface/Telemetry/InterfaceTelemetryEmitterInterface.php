<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\EmitterInterface\Telemetry;

use App\Interfacing\Event\InterfaceTelemetryEvent;

interface InterfaceTelemetryEmitterInterface
{
    public function emit(InterfaceTelemetryEvent $event): void;
}
