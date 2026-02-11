<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Http\Interfacing\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 *
 */

/**
 *
 */
final class InterfacingDoctorController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/interfacing/doctor/page', name: 'interfacing_doctor_page', methods: ['GET'])]
    public function __invoke(): Response
    {
        // RVE-B5: keep a single canonical doctor page template.
        return $this->render('interfacing/doctor/page.html.twig');
    }
}

