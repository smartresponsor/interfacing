<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Http\Interfacing\Controller;

use App\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class DoctorController
{
    public function __construct(
        private readonly DoctorReportBuilderInterface $reportBuilder,
        private readonly DoctorReportNormalizerInterface $normalizer,
        private readonly Environment $twig
    ) {}

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
