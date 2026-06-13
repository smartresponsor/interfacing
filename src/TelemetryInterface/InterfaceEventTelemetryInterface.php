<?php

declare(strict_types=1);

namespace App\Interfacing\TelemetryInterface;

interface InterfaceEventTelemetryInterface
{
    /** @param array<string, mixed> $meta */
    public function event(string $nameEntity, array $meta = []): void;
}
