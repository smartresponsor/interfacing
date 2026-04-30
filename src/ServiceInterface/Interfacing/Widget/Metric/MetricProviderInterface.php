<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Widget\Metric;

use App\Interfacing\Contract\View\MetricDatum;

interface MetricProviderInterface
{
    public function id(): string;

    /**
     * @return list<MetricDatum>
     */
    public function list(array $context = []): array;
}
