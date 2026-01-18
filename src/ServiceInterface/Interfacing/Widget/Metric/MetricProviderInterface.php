<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Metric;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Metric\MetricDatum;

interface MetricProviderInterface
{
    public function id(): string;

    /**
     * @return list<MetricDatum>
     */
    public function list(array $context = []): array;
}
