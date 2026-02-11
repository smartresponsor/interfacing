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
interface MetricCardInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return float
     */
    public function current(): float;

    /**
     * @return float
     */
    public function previous(): float;

    /**
     * @return float
     */
    public function delta(): float;

    /**
     * @return float
     */
    public function deltaPercent(): float;

    /**
     * @return string
     */
    public function format(): string;

    /**
     * @return string
     */
    public function unit(): string;

    /**
     * @return bool
     */
    public function isUp(): bool;

    /**
     * @return bool
     */
    public function isDown(): bool;
}
