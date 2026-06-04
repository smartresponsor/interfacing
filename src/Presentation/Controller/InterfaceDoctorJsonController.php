<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\BuilderInterface\Doctor\InterfaceDoctorReportBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceDoctorJsonController
{
    public function __construct(private InterfaceDoctorReportBuilderInterface $reportBuilder)
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
