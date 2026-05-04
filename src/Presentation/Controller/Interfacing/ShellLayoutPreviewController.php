<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellLayoutPreviewProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShellLayoutPreviewController extends AbstractController
{
    public function __construct(
        private readonly ShellChromeProviderInterface $shellChromeProvider,
        private readonly ShellLayoutPreviewProviderInterface $shellLayoutPreviewProvider,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/shell/layout-preview', name: 'interfacing_shell_layout_preview', methods: ['GET'])]
    public function index(): Response
    {
        $shell = $this->shellChromeProvider->provide('shell.layout.preview');

        return $this->renderer->render('interfacing/page/shell_layout_preview.html.twig', [
            'title' => 'Interfacing shell layout preview',
            'screenId' => 'shell.layout.preview',
            'shell' => $shell,
            'layoutPreview' => $this->shellLayoutPreviewProvider->preview('shell.layout.preview'),
        ]);
    }

    #[Route('/interfacing/shell/layout-preview.json', name: 'interfacing_shell_layout_preview_json', methods: ['GET'])]
    public function shellLayoutPreviewJson(): JsonResponse
    {
        return new JsonResponse($this->shellLayoutPreviewProvider->preview('shell.layout.preview'));
    }
}
