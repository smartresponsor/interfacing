<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\Factory\Compliance\InterfaceComplianceSurfaceContractFactory;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceComplianceSurfaceController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceComplianceSurfaceContractFactory $surfaceContractFactory,
    ) {
    }

    #[Route('/interfacing/surface/compliance', name: 'interfacing_compliance_index', methods: ['GET'], priority: 1300)]
    #[Route('/interfacing/surface/compliance/alias', name: 'interfacing_compliance_index_no_slash', methods: ['GET'], priority: 1300)]
    public function index(Request $request): Response
    {
        $surface = $this->surfaceContractFactory->create([
            'query' => (string) $request->query->get('q', ''),
        ]);

        return $this->renderer->renderSurface($surface);
    }
}
