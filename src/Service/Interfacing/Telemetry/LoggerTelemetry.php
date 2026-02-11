<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Telemetry;

use Psr\Log\LoggerInterface;
use App\DomainInterface\Interfacing\Telemetry\TelemetryInterface;

/**
 *
 */

/**
 *
 */
final readonly class LoggerTelemetry implements TelemetryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger) {}

    /**
     * @param string $name
     * @param array $meta
     * @return void
     */
    public function event(string $name, array $meta = []): void
    {
        $this->logger->info('[interfacing] ' . $name, $meta);
    }
}
