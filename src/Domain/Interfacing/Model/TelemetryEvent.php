<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

final class TelemetryEvent
{
    /** @param array<string,string|int|float|bool> $tag */
    public function __construct(
        private string $name,
        private array $tag,
        private float $durationMs
    ) {
        if ($name === '') {
            throw new \InvalidArgumentException('Telemetry event name must not be empty.');
        }
    }

    public function name(): string { return $this->name; }
    /** @return array<string,string|int|float|bool> */
    public function tag(): array { return $this->tag; }
    public function durationMs(): float { return $this->durationMs; }
}
