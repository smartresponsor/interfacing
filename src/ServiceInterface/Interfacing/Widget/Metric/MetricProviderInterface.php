<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\Metric;

use App\Domain\Interfacing\Model\Metric\MetricDatum;

/**
 *
 */

/**
 *
 */
interface MetricProviderInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return list<MetricDatum>
     */
    public function list(array $context = []): array;
}
