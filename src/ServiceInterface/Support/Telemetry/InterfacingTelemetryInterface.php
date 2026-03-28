<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Support\Telemetry;

interface InterfacingTelemetryInterface
{
    /** @param array<string, string|int|float|bool> $meta */
    public function mark(string $name, array $meta = []): void;

    /** @param array<string, string|int|float|bool> $meta */
    public function timing(string $name, float $ms, array $meta = []): void;

    /** @param array<string, string|int|float|bool> $meta */
    public function count(string $name, int $value = 1, array $meta = []): void;
}
