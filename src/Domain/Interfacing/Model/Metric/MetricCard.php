<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Metric;

/**
 *
 */

/**
 *
 */
final class MetricCard
{
    /**
     * @param string $id
     * @param string $title
     * @param float $current
     * @param float $previous
     * @param string $format
     * @param string $unit
     */
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly float  $current,
        private readonly float  $previous,
        private readonly string $format = 'int',
        private readonly string $unit = '',
    ) {
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function current(): float
    {
        return $this->current;
    }

    /**
     * @return float
     */
    public function previous(): float
    {
        return $this->previous;
    }

    /**
     * @return float
     */
    public function delta(): float
    {
        return $this->current - $this->previous;
    }

    /**
     * @return float
     */
    public function deltaPercent(): float
    {
        if ($this->previous == 0.0) {
            return 0.0;
        }

        return (($this->current - $this->previous) / $this->previous) * 100.0;
    }

    /**
     * @return string
     */
    public function format(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function unit(): string
    {
        return $this->unit;
    }

    /**
     * @return bool
     */
    public function isUp(): bool
    {
        return $this->delta() > 0.0;
    }

    /**
     * @return bool
     */
    public function isDown(): bool
    {
        return $this->delta() < 0.0;
    }
}
