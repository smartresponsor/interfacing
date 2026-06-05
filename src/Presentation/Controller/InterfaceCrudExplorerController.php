<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\BuilderInterface\View\InterfaceCrudExplorerViewBuilderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceCrudExplorerController
{
    public function __construct(
        private InterfaceCrudExplorerViewBuilderInterface $viewBuilder,
        private InterfaceRendererInterface $interfacingRenderer,
    ) {
    }

    #[Route('/interfacing/resource/explorer', name: 'interfacing_crud_explorer', methods: ['GET'])]
    public function index(): Response
    {
        return $this->interfacingRenderer->render(
            'page/crud_explorer.html.twig',
            $this->viewBuilder->buildPage(),
        );
    }

    #[Route('/interfacing/resource/explorer/links.json', name: 'interfacing_crud_explorer_links', methods: ['GET'])]
    public function links(): JsonResponse
    {
        return new JsonResponse($this->viewBuilder->buildLinksPayload());
    }

    #[Route('/interfacing/resource/explorer/route-expectations.json', name: 'interfacing_crud_explorer_route_expectations', methods: ['GET'])]
    public function routeExpectations(): JsonResponse
    {
        return new JsonResponse($this->viewBuilder->buildRouteExpectationsPayload());
    }

    #[Route('/interfacing/resource/explorer/operations.json', name: 'interfacing_crud_explorer_operations', methods: ['GET'])]
    public function operations(): JsonResponse
    {
        return new JsonResponse($this->viewBuilder->buildOperationsPayload());
    }
}
