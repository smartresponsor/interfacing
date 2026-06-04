<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\MetricInterface\InterfaceUiMetricInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceMetricController
{
    public function __construct(private InterfaceUiMetricInterface $metric)
    {
    }

    #[Route('/interfacing/metrics', name: 'interfacing_metrics', methods: ['GET'])]
    public function metrics(): Response
    {
        return new Response($this->metric->render(), 200, [
            'Content-Type' => 'text/plain; version=0.0.4',
        ]);
    }
}
