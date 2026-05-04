<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellPanelDiagnosticsProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class ShellPanelDiagnosticsController
{
    public function __construct(
        private InterfacingRendererInterface $renderer,
        private ShellPanelDiagnosticsProviderInterface $diagnosticsProvider,
    ) {
    }

    #[Route('/interfacing/shell/diagnostics', name: 'interfacing_shell_diagnostics', methods: ['GET'])]
    public function page(): Response
    {
        return $this->renderer->render('interfacing/page/shell_diagnostics.html.twig', [
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
