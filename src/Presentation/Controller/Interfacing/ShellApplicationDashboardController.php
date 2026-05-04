<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShellApplicationDashboardController extends AbstractController
{
    public function __construct(
        private readonly ShellChromeProviderInterface $shellChromeProvider,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/applications', name: 'interfacing_application_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        $shell = $this->shellChromeProvider->provide('applications.dashboard');

        return $this->renderer->render('interfacing/page/application_dashboard.html.twig', [
            'title' => 'Interfacing application dashboard',
            'screenId' => 'applications.dashboard',
            'shell' => $shell,
            'applicationDashboard' => $shell['applicationDashboard'] ?? [],
        ]);
    }

    #[Route('/interfacing/applications.json', name: 'interfacing_application_dashboard_json', methods: ['GET'])]
    public function shellApplicationsJson(): JsonResponse
    {
        $shell = $this->shellChromeProvider->provide('applications.dashboard');

        return new JsonResponse($shell['applicationDashboard'] ?? []);
    }
}
