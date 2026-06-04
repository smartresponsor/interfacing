<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ProviderInterface\Widget\Metric;

use App\Interfacing\Contract\View\InterfaceMetricDatum;

interface InterfaceMetricProviderInterface
{
    public function id(): string;

    /**
     * @return list<InterfaceMetricDatum>
     */
    public function list(array $context = []): array;
}
