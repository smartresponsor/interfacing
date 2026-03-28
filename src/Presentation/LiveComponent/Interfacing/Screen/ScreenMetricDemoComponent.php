<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\LiveComponent\Interfacing\Screen;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_screen_metric_demo', template: 'interfacing/screen/metric-demo.html.twig')]
final class ScreenMetricDemoComponent
{
    #[LiveProp]
    public array $context = [];
}
