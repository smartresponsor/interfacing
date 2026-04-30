<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final readonly class DoctorController
{
    public function __construct(
        private DoctorReportBuilderInterface $reportBuilder,
        private DoctorReportNormalizerInterface $normalizer,
        private Environment $twig,
    ) {
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(): Response
    {
        $raw = $this->reportBuilder->build();
        $report = $this->normalizer->normalize($raw);
        // RVE-B5: /interfacing/doctor is the canonical human doctor endpoint.
        $html = $this->twig->render('interfacing/doctor.html.twig', [
            'report' => $report,
        ]);

        return new Response($html);
    }
}
