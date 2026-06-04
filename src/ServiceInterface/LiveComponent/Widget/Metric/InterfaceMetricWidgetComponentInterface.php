<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\LiveComponent\Widget\Metric;

use App\Interfacing\Contract\View\InterfaceMetricDatum;

interface InterfaceMetricWidgetComponentInterface
{
    /**
     * @return list<InterfaceMetricDatum>
     */
    public function metricList(): array;
}
