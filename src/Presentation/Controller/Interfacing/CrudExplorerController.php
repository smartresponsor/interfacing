<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\CrudExplorerViewBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class CrudExplorerController
{
    public function __construct(
        private CrudExplorerViewBuilderInterface $viewBuilder,
        private InterfacingRendererInterface $interfacingRenderer,
    ) {
    }

    #[Route('/interfacing/crud/explorer', name: 'interfacing_crud_explorer', methods: ['GET'])]
    public function index(): Response
    {
        return $this->interfacingRenderer->render(
            'interfacing/page/crud_explorer.html.twig',
            $this->viewBuilder->buildPage(),
        );
    }

    #[Route('/interfacing/crud/explorer/links.json', name: 'interfacing_crud_explorer_links', methods: ['GET'])]
    public function links(): JsonResponse
    {
        return new JsonResponse($this->viewBuilder->buildLinksPayload());
    }

    #[Route('/interfacing/crud/explorer/route-expectations.json', name: 'interfacing_crud_explorer_route_expectations', methods: ['GET'])]
    public function routeExpectations(): JsonResponse
    {
        return new JsonResponse($this->viewBuilder->buildRouteExpectationsPayload());
    }

    #[Route('/interfacing/crud/explorer/operations.json', name: 'interfacing_crud_explorer_operations', methods: ['GET'])]
    public function operations(): JsonResponse
    {
        return new JsonResponse($this->viewBuilder->buildOperationsPayload());
    }
}
