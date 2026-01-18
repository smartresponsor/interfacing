<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\InfraInterface\Interfacing\Live\Widget\Metric;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Metric\MetricDatum;

interface MetricWidgetComponentInterface
{
    /**
     * @return list<MetricDatum>
     */
    public function metricList(): array;
}
