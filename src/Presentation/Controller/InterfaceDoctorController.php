<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceDoctorController
{
    public function __construct(private InterfaceRendererInterface $renderer)
    {
    }

    #[Route('/interfacing/doctor/page', name: 'interfacing_doctor_page', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->renderer->render('doctor/page.html.twig', [
            'title' => 'Doctor component',
            'screenId' => 'interfacing.doctor.page',
        ]);
    }
}
