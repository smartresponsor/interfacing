<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellScreenCatalogProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShellScreenCatalogController extends AbstractController
{
    public function __construct(
        private readonly ShellChromeProviderInterface $shellChromeProvider,
        private readonly ShellScreenCatalogProviderInterface $shellScreenCatalogProvider,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/shell/screens', name: 'interfacing_shell_screen_catalog', methods: ['GET'])]
    public function index(): Response
    {
        $shell = $this->shellChromeProvider->provide('shell.screens');

        return $this->renderer->render('interfacing/page/shell_screen_catalog.html.twig', [
            'title' => 'Interfacing shell screen catalog',
            'screenId' => 'shell.screens',
            'shell' => $shell,
            'screenCatalog' => $this->shellScreenCatalogProvider->catalog('shell.screens'),
        ]);
    }

    #[Route('/interfacing/shell/screens.json', name: 'interfacing_shell_screen_catalog_json', methods: ['GET'])]
    public function shellScreenCatalogJson(): JsonResponse
    {
        return new JsonResponse($this->shellScreenCatalogProvider->catalog('shell.screens'));
    }
}
