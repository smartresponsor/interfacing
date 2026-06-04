<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Commerce\InterfaceProjectShowcaseProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceProjectShowcaseController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceProjectShowcaseProviderInterface $projectShowcaseProvider,
    ) {
    }

    #[Route('/interfacing/showcase/project', name: 'interfacing_project_storefront', methods: ['GET'], priority: 1300)]
    #[Route('/interfacing/showcase/project/alias', name: 'interfacing_project_storefront_no_slash', methods: ['GET'], priority: 1300)]
    public function index(Request $request): Response
    {
        return $this->renderer->render('project/project_showcase.html.twig', [
            'screenId' => 'project.storefront',
            'title' => 'Projects · Smart Responsor',
            'projectShowcase' => $this->projectShowcaseProvider->provide($request->query->all()),
        ]);
    }
}
