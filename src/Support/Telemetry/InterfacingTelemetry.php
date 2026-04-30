<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Support\Telemetry;

use App\Interfacing\ServiceInterface\Support\Telemetry\InterfacingTelemetryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

final class InterfacingTelemetry implements InterfacingTelemetryInterface
{
    private ?Stopwatch $stopwatch;

    public function __construct(private readonly LoggerInterface $logger, ?Stopwatch $stopwatch = null)
    {
        $this->stopwatch = $stopwatch;
    }

    public function mark(string $name, array $meta = []): void
    {
        $this->logger->info('[interfacing] mark '.$name, $this->meta($meta));
    }

    public function timing(string $name, float $ms, array $meta = []): void
    {
        $data = $this->meta($meta);
        $data['ms'] = $ms;
        $this->logger->info('[interfacing] timing '.$name, $data);
    }

    public function count(string $name, int $value = 1, array $meta = []): void
    {
        $data = $this->meta($meta);
        $data['value'] = $value;
        $this->logger->info('[interfacing] count '.$name, $data);
    }

    /** @return array<string, mixed> */
    private function meta(array $meta): array
    {
        $out = [];
        foreach ($meta as $k => $v) {
            $out[$k] = $v;
        }

        return $out;
    }
}
