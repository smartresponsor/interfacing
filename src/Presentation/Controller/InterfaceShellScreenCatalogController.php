<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Shell\InterfaceShellScreenCatalogProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfaceShellScreenCatalogController extends AbstractController
{
    public function __construct(
        private readonly InterfaceShellScreenCatalogProviderInterface $shellScreenCatalogProvider,
        private readonly InterfaceRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/shell/screens', name: 'interfacing_shell_screen_catalog', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('page/shell_screen_catalog.html.twig', [
            'title' => 'Interfacing shell screen catalog',
            'screenId' => 'shell.screens',
            'screenCatalog' => $this->shellScreenCatalogProvider->catalog('shell.screens'),
        ]);
    }

    #[Route('/interfacing/shell/screens.json', name: 'interfacing_shell_screen_catalog_json', methods: ['GET'])]
    public function shellScreenCatalogJson(): JsonResponse
    {
        return new JsonResponse($this->shellScreenCatalogProvider->catalog('shell.screens'));
    }
}
