<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Http\Interfacing\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class InterfacingDoctorController extends AbstractController
{
    #[Route('/interfacing/doctor', name: 'interfacing_doctor', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('interfacing/doctor/page.html.twig');
    }
}

