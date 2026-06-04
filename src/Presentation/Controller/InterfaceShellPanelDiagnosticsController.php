<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Shell\InterfaceShellPanelDiagnosticsProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceShellPanelDiagnosticsController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceShellPanelDiagnosticsProviderInterface $diagnosticsProvider,
    ) {
    }

    #[Route('/interfacing/shell/diagnostics', name: 'interfacing_shell_diagnostics', methods: ['GET'])]
    public function page(): Response
    {
        return $this->renderer->render('page/shell_diagnostics.html.twig', [
            'title' => 'Interfacing shell diagnostics',
            'screenId' => 'shell.diagnostics',
            'diagnostics' => $this->diagnosticsProvider->report('shell.diagnostics'),
        ]);
    }

    #[Route('/interfacing/shell/diagnostics.json', name: 'interfacing_shell_diagnostics_json', methods: ['GET'])]
    public function shellDiagnosticsJson(): JsonResponse
    {
        return new JsonResponse($this->diagnosticsProvider->report('shell.diagnostics'));
    }
}
