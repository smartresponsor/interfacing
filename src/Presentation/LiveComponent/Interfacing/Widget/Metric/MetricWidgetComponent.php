<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Widget\Metric;

use App\Interfacing\Contract\View\MetricDatum;
use App\Interfacing\ServiceInterface\Interfacing\Widget\Metric\MetricProviderRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_metric', template: 'interfacing/widget/metric/metric.html.twig')]
final class MetricWidgetComponent
{
    #[LiveProp]
    public string $providerId = 'demo';

    #[LiveProp]
    public array $context = [];

    #[LiveProp(writable: true)]
    public int $tick = 0;

    public function __construct(private readonly MetricProviderRegistryInterface $registry)
    {
    }

    public function __invoke(): void
    {
    }

    /** @return list<MetricDatum> */
    public function metricList(): array
    {
        return $this->registry->get($this->providerId)->list($this->context);
    }

    #[LiveAction]
    public function refresh(): void
    {
        ++$this->tick;
    }
}
