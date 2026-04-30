<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Metric\UiMetricInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfacingMetricController
{
    public function __construct(private UiMetricInterface $metric)
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
