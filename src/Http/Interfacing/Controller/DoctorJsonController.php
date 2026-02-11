<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Http\Interfacing\Controller;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DoctorJsonController
{
    public function __construct(private readonly DoctorReportBuilderInterface $reportBuilder) {}

    #[Route(path: '/interfacing/doctor.json', name: 'interfacing_doctor_json', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->reportBuilder->build(), 200, [
            'Cache-Control' => 'no-store',
        ]);
    }
}
