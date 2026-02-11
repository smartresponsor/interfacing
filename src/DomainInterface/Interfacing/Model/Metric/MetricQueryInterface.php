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
interface MetricQueryInterface
{
    /**
     * @return string
     */
    public function range(): string;

    /**
     * @return string
     */
    public function timezone(): string;
}
