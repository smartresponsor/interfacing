<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Shell\InterfaceShellLayoutPreviewProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfaceShellLayoutPreviewController extends AbstractController
{
    public function __construct(
        private readonly InterfaceShellLayoutPreviewProviderInterface $shellLayoutPreviewProvider,
        private readonly InterfaceRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/shell/layout-preview', name: 'interfacing_shell_layout_preview', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('page/shell_layout_preview.html.twig', [
            'title' => 'Interfacing shell layout preview',
            'screenId' => 'shell.layout.preview',
            'layoutPreview' => $this->shellLayoutPreviewProvider->preview('shell.layout.preview'),
        ]);
    }

    #[Route('/interfacing/shell/layout-preview.json', name: 'interfacing_shell_layout_preview_json', methods: ['GET'])]
    public function shellLayoutPreviewJson(): JsonResponse
    {
        return new JsonResponse($this->shellLayoutPreviewProvider->preview('shell.layout.preview'));
    }
}
