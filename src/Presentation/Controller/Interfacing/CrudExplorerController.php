<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class CrudExplorerController
{
    public function __construct(
        private CrudResourceExplorerProviderInterface $crudResourceExplorerProvider,
        private InterfacingRendererInterface $interfacingRenderer,
    ) {
    }

    #[Route('/interfacing/crud/explorer', name: 'interfacing_crud_explorer', methods: ['GET'])]
    public function index(): Response
    {
        return $this->interfacingRenderer->render('interfacing/page/crud_explorer.html.twig', [
            'title' => 'CRUD Explorer',
            'shell' => null,
            'screenId' => 'crud.explorer',
            'resourceSet' => $this->crudResourceExplorerProvider->provide(),
        ]);
    }
}
