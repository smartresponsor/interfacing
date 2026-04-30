<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class MetricCard
{
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly float $current,
        private readonly float $previous,
        private readonly string $format = 'int',
        private readonly string $unit = '',
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function current(): float
    {
        return $this->current;
    }

    public function previous(): float
    {
        return $this->previous;
    }

    public function delta(): float
    {
        return $this->current - $this->previous;
    }

    public function deltaPercent(): float
    {
        if (0.0 == $this->previous) {
            return 0.0;
        }

        return (($this->current - $this->previous) / $this->previous) * 100.0;
    }

    public function format(): string
    {
        return $this->format;
    }

    public function unit(): string
    {
        return $this->unit;
    }

    public function isUp(): bool
    {
        return $this->delta() > 0.0;
    }

    public function isDown(): bool
    {
        return $this->delta() < 0.0;
    }
}
