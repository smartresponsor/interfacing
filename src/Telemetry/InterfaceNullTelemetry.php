<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Telemetry;

use App\Interfacing\TelemetryInterface\InterfaceEventTelemetryInterface;

final class InterfaceNullTelemetry implements InterfaceEventTelemetryInterface
{
    public function event(string $name, array $meta = []): void
    {
        // no-op
    }
}
