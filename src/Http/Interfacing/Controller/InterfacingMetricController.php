<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Http\Interfacing\Controller;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Metric\UiMetricInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 *
 */

/**
 *
 */
final readonly class InterfacingMetricController
{
    /**
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Metric\UiMetricInterface $metric
     */
    public function __construct(private UiMetricInterface $metric) {}

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/interfacing/metrics', name: 'interfacing_metrics', methods: ['GET'])]
    public function metrics(): Response
    {
        return new Response($this->metric->render(), 200, [
            'Content-Type' => 'text/plain; version=0.0.4',
        ]);
    }
}
