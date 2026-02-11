<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\Metric;

use App\Domain\Interfacing\Model\Metric\MetricDatum;

/**
 *
 */

/**
 *
 */
interface MetricWidgetComponentInterface
{
    /**
     * @return list<MetricDatum>
     */
    public function metricList(): array;
}
