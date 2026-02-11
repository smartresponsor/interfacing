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
interface MetricSpecInterface
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
     * @return string
     */
    public function format(): string;

    /**
     * @return string
     */
    public function unit(): string;
}
