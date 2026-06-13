<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Telemetry;

use App\Interfacing\TelemetryInterface\InterfaceTelemetryInterface;
use Psr\Log\LoggerInterface;

final class InterfaceTelemetry implements InterfaceTelemetryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function mark(string $nameEntity, array $meta = []): void
    {
        $this->logger->info('[interfacing] mark '.$nameEntity, $this->meta($meta));
    }

    public function timing(string $nameEntity, float $ms, array $meta = []): void
    {
        $data = $this->meta($meta);
        $data['ms'] = $ms;
        $this->logger->info('[interfacing] timing '.$nameEntity, $data);
    }

    public function count(string $nameEntity, int $value = 1, array $meta = []): void
    {
        $data = $this->meta($meta);
        $data['value'] = $value;
        $this->logger->info('[interfacing] count '.$nameEntity, $data);
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
