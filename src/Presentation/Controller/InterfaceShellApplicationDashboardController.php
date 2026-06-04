<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfaceShellApplicationDashboardController extends AbstractController
{
    public function __construct(
        private readonly InterfaceShellChromeProviderInterface $shellChromeProvider,
        private readonly InterfaceRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/applications', name: 'interfacing_application_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        $shell = $this->shellChromeProvider->provide('applications.dashboard', true, true);

        return $this->renderer->render('page/application_dashboard.html.twig', [
            'title' => 'Interfacing application dashboard',
            'screenId' => 'applications.dashboard',
            'shell' => $shell,
            'applicationDashboard' => $shell['applicationDashboard'] ?? [],
        ]);
    }

    #[Route('/interfacing/applications.json', name: 'interfacing_application_dashboard_json', methods: ['GET'])]
    public function shellApplicationsJson(): JsonResponse
    {
        $shell = $this->shellChromeProvider->provide('applications.dashboard', true, true);

        return new JsonResponse($shell['applicationDashboard'] ?? []);
    }
}
