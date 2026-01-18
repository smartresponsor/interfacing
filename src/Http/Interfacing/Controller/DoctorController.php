<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Http\Interfacing\Controller;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class DoctorController
{
    public function __construct(
        private readonly DoctorReportBuilderInterface $reportBuilder,
        private readonly Environment $twig
    ) {}

    #[Route(path: '/interfacing/doctor', name: 'interfacing_doctor', methods: ['GET'])]
    public function __invoke(): Response
    {
        $html = $this->twig->render('interfacing/doctor.html.twig', [
            'report' => $this->reportBuilder->build(),
        ]);
        return new Response($html);
    }
}
