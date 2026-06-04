<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Widget\Metric;

use App\Interfacing\Contract\View\InterfaceMetricDatum;
use App\Interfacing\RegistryInterface\Widget\Metric\InterfaceMetricProviderRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_metric', template: 'widget/metric/metric.html.twig')]
final class InterfaceMetricWidgetComponent
{
    #[LiveProp]
    public string $providerId = 'demo';

    #[LiveProp]
    public array $context = [];

    #[LiveProp(writable: true)]
    public int $tick = 0;

    public function __construct(private readonly InterfaceMetricProviderRegistryInterface $registry)
    {
    }

    public function __invoke(): void
    {
    }

    /** @return list<InterfaceMetricDatum> */
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
