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
final class MetricDatum
{
    /**
     * @param string $key
     * @param string $title
     * @param float $value
     * @param string $unit
     * @param float|null $delta
     */
    public function __construct(
        private string          $key,
        private readonly string $title,
        private readonly float  $value,
        private string          $unit = '',
        private readonly ?float $delta = null,
    ) {
        $this->key = trim($this->key);
        if ($this->key === '') {
            throw new \InvalidArgumentException('MetricDatum key must be non-empty.');
        }
        $this->unit = trim($this->unit);
    }

    /**
     * @return string
     */
    public function key(): string { return $this->key; }

    /**
     * @return string
     */
    public function title(): string { return $this->title; }

    /**
     * @return float
     */
    public function value(): float { return $this->value; }

    /**
     * @return string
     */
    public function unit(): string { return $this->unit; }

    /**
     * @return float|null
     */
    public function delta(): ?float { return $this->delta; }
}
