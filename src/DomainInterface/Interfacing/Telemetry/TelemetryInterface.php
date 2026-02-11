<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\DomainInterface\Interfacing\Telemetry;

interface TelemetryInterface
{
    /** @param array<string, mixed> $meta */
    public function event(string $name, array $meta = []): void;
}
