<?php

declare(strict_types=1);

namespace App\Interfacing\Event;

/**
 * Carries one immutable telemetry measurement emitted by Interfacing runtime surfaces.
 */
final class InterfaceTelemetryEvent
{
    /** @param array<string,string|int|float|bool> $tag */
    public function __construct(
        private readonly string $nameEntity,
        private readonly array $tag,
        private readonly float $durationMs,
    ) {
        if ('' === $nameEntity) {
            throw new \InvalidArgumentException('Telemetry event nameEntity must not be empty.');
        }
    }

    public function nameEntity(): string
    {
        return $this->nameEntity;
    }

    /** @return array<string,string|int|float|bool> */
    public function tag(): array
    {
        return $this->tag;
    }

    public function durationMs(): float
    {
        return $this->durationMs;
    }
}
