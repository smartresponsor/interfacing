<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Metric;

final class MetricDatum
{
    public function __construct(
        private string $key,
        private string $title,
        private float $value,
        private string $unit = '',
        private ?float $delta = null,
    ) {
        $this->key = trim($this->key);
        if ($this->key === '') {
            throw new \InvalidArgumentException('MetricDatum key must be non-empty.');
        }
        $this->unit = trim($this->unit);
    }

    public function key(): string { return $this->key; }
    public function title(): string { return $this->title; }
    public function value(): float { return $this->value; }
    public function unit(): string { return $this->unit; }
    public function delta(): ?float { return $this->delta; }
}
