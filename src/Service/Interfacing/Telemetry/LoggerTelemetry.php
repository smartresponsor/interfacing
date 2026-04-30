<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Telemetry;

use App\Interfacing\ServiceInterface\Interfacing\Telemetry\TelemetryInterface;
use Psr\Log\LoggerInterface;

final readonly class LoggerTelemetry implements TelemetryInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function event(string $name, array $meta = []): void
    {
        $this->logger->info('[interfacing] '.$name, $meta);
    }
}
