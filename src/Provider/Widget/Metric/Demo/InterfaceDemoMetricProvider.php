<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Provider\Widget\Metric\Demo;

use App\Interfacing\Contract\View\InterfaceMetricDatum;
use App\Interfacing\ProviderInterface\Widget\Metric\InterfaceMetricProviderInterface;

final class InterfaceDemoMetricProvider implements InterfaceMetricProviderInterface
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
            new InterfaceMetricDatum('uptime', 'Uptime', (float) ($sec % 100000), 's', 1.0),
            new InterfaceMetricDatum('clock', 'Clock', (float) $ms, 'ms', null),
            new InterfaceMetricDatum('success', 'Success rate', 99.3, '%', 0.1),
            new InterfaceMetricDatum('seed', 'Seed salt', (float) $salt, '', null),
        ];
    }
}
