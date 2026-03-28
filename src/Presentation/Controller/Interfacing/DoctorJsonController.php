<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Presentation\Controller\Interfacing;

use App\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class DoctorJsonController
{
    public function __construct(private DoctorReportBuilderInterface $reportBuilder)
    {
    }

    #[Route(path: '/interfacing/doctor.json', name: 'interfacing_doctor_json', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->reportBuilder->build(), 200, [
            'Cache-Control' => 'no-store',
        ]);
    }
}
