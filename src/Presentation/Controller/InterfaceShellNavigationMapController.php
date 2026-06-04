<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Shell\InterfaceShellNavigationMapProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceShellNavigationMapController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceShellNavigationMapProviderInterface $navigationMapProvider,
    ) {
    }

    #[Route('/interfacing/shell/navigation', name: 'interfacing_shell_navigation', methods: ['GET'])]
    public function page(): Response
    {
        return $this->renderer->render('page/shell_navigation.html.twig', [
            'title' => 'Interfacing shell navigation map',
            'screenId' => 'shell.navigation',
            'navigationMap' => $this->navigationMapProvider->map('shell.navigation'),
        ]);
    }

    #[Route('/interfacing/shell/navigation.json', name: 'interfacing_shell_navigation_json', methods: ['GET'])]
    public function shellNavigationMapJson(): JsonResponse
    {
        return new JsonResponse($this->navigationMapProvider->map('shell.navigation'));
    }
}
