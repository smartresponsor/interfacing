<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Telemetry;

interface TelemetryInterface
{
    /** @param array<string, mixed> $meta */
    public function event(string $name, array $meta = []): void;
}
