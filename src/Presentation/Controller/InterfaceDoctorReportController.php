<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\BuilderInterface\Doctor\InterfaceDoctorReportBuilderInterface;
use App\Interfacing\NormalizerInterface\Doctor\InterfaceDoctorReportNormalizerInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Response;

final readonly class InterfaceDoctorReportController
{
    public function __construct(
        private InterfaceDoctorReportBuilderInterface $reportBuilder,
        private InterfaceDoctorReportNormalizerInterface $normalizer,
        private InterfaceRendererInterface $renderer,
    ) {
    }

    public function __invoke(): Response
    {
        $raw = $this->reportBuilder->build();
        $report = $this->normalizer->normalize($raw);

        return $this->renderer->render('doctor.html.twig', [
            'title' => 'Interfacing Doctor',
            'screenId' => 'interfacing.doctor',
            'report' => $report,
        ]);
    }
}
