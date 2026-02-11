<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\Metric;

/**
 *
 */

/**
 *
 */
interface MetricDatumInterface
{
    /**
     * @return string
     */
    public function key(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return float
     */
    public function value(): float;

    /**
     * @return string
     */
    public function unit(): string;

    /**
     * @return float|null
     */
    public function delta(): ?float;
}
