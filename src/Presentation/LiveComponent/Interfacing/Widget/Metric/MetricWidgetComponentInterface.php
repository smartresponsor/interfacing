<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Widget\Metric;

use App\Interfacing\Contract\View\MetricDatum;

interface MetricWidgetComponentInterface
{
    /**
     * @return list<MetricDatum>
     */
    public function metricList(): array;
}
