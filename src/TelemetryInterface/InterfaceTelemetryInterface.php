<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\TelemetryInterface;

interface InterfaceTelemetryInterface
{
    /** @param array<string, string|int|float|bool> $meta */
    public function mark(string $nameEntity, array $meta = []): void;

    /** @param array<string, string|int|float|bool> $meta */
    public function timing(string $nameEntity, float $ms, array $meta = []): void;

    /** @param array<string, string|int|float|bool> $meta */
    public function count(string $nameEntity, int $value = 1, array $meta = []): void;
}
