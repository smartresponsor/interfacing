<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Telemetry;

use App\ServiceInterface\Interfacing\Telemetry\TelemetryInterface;

final class NullTelemetry implements TelemetryInterface
{
    public function event(string $name, array $meta = []): void
    {
        // no-op
    }
}
