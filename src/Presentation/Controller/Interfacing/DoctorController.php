<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Component\HttpFoundation\Response;

final readonly class DoctorController
{
    public function __construct(
        private DoctorReportBuilderInterface $reportBuilder,
        private DoctorReportNormalizerInterface $normalizer,
        private InterfacingRendererInterface $renderer,
    ) {
    }

    public function __invoke(): Response
    {
        $raw = $this->reportBuilder->build();
        $report = $this->normalizer->normalize($raw);

        return $this->renderer->render('interfacing/doctor.html.twig', [
            'title' => 'Interfacing Doctor',
            'screenId' => 'interfacing.doctor',
            'report' => $report,
        ]);
    }
}
