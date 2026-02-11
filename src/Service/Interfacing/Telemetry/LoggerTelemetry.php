<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Telemetry;

use Psr\Log\LoggerInterface;
use App\DomainInterface\Interfacing\Telemetry\TelemetryInterface;

final class LoggerTelemetry implements TelemetryInterface
{
    public function __construct(private readonly LoggerInterface $logger) {}

    public function event(string $name, array $meta = []): void
    {
        $this->logger->info('[interfacing] ' . $name, $meta);
    }
}
