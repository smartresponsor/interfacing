<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Infra\Interfacing\Telemetry;

use Psr\Log\LoggerInterface;
use App\InfraInterface\Interfacing\Telemetry\InterfacingTelemetryInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 *
 */

/**
 *
 */
final class InterfacingTelemetry implements InterfacingTelemetryInterface
{
    private ?Stopwatch $stopwatch;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Symfony\Component\Stopwatch\Stopwatch|null $stopwatch
     */
    public function __construct(private readonly LoggerInterface $logger, ?Stopwatch $stopwatch = null)
    {
        $this->stopwatch = $stopwatch;
    }

    /**
     * @param string $name
     * @param array $meta
     * @return void
     */
    public function mark(string $name, array $meta = []): void
    {
        $this->logger->info('[interfacing] mark ' . $name, $this->meta($meta));
    }

    /**
     * @param string $name
     * @param float $ms
     * @param array $meta
     * @return void
     */
    public function timing(string $name, float $ms, array $meta = []): void
    {
        $data = $this->meta($meta);
        $data['ms'] = $ms;
        $this->logger->info('[interfacing] timing ' . $name, $data);
    }

    /**
     * @param string $name
     * @param int $value
     * @param array $meta
     * @return void
     */
    public function count(string $name, int $value = 1, array $meta = []): void
    {
        $data = $this->meta($meta);
        $data['value'] = $value;
        $this->logger->info('[interfacing] count ' . $name, $data);
    }

    /** @return array<string, mixed> */
    private function meta(array $meta): array
    {
        $out = [];
        foreach ($meta as $k => $v) { $out[$k] = $v; }
        return $out;
    }
}

