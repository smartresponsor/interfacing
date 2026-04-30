<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfacingDoctorController
{
    public function __construct(private InterfacingRendererInterface $renderer)
    {
    }

    #[Route('/interfacing/doctor/page', name: 'interfacing_doctor_page', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->renderer->render('interfacing/doctor/page.html.twig', [
            'title' => 'Doctor component',
            'screenId' => 'interfacing.doctor.page',
        ]);
    }
}
