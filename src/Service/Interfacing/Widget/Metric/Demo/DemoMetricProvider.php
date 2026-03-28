<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Service\Interfacing\Widget\Metric\Demo;

use App\Contract\View\MetricDatum;
use App\ServiceInterface\Interfacing\Widget\Metric\MetricProviderInterface;

final class DemoMetricProvider implements MetricProviderInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function list(array $context = []): array
    {
        $t = microtime(true);
        $sec = (int) $t;
        $ms = (int) (($t - $sec) * 1000);

        $seed = (string) ($context['demo']['seed'] ?? '');
        $salt = '' !== $seed ? hexdec(substr(hash('sha256', $seed), 0, 2)) : 0;

        return [
            new MetricDatum('uptime', 'Uptime', (float) ($sec % 100000), 's', 1.0),
            new MetricDatum('clock', 'Clock', (float) $ms, 'ms', null),
            new MetricDatum('success', 'Success rate', 99.3, '%', 0.1),
            new MetricDatum('seed', 'Seed salt', (float) $salt, '', null),
        ];
    }
}
