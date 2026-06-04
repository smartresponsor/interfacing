<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Commerce\InterfaceCategoryShowcaseProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceCategoryShowcaseController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceCategoryShowcaseProviderInterface $categoryShowcaseProvider,
    ) {
    }

    #[Route('/interfacing/showcase/catalog/category', name: 'interfacing_catalog_category_showcase', methods: ['GET'], priority: 1350)]
    #[Route('/interfacing/showcase/catalog/category/alias', name: 'interfacing_catalog_category_showcase_no_slash', methods: ['GET'], priority: 1350)]
    #[Route('/interfacing/showcase/category', name: 'interfacing_category_showcase', methods: ['GET'], priority: 1250)]
    #[Route('/interfacing/showcase/category/alias', name: 'interfacing_category_showcase_no_slash', methods: ['GET'], priority: 1250)]
    public function index(Request $request): Response
    {
        return $this->renderer->render('catalog/category_showcase.html.twig', [
            'screenId' => 'provider.category',
            'title' => 'Categories · Smart Responsor',
            'categoryShowcase' => $this->categoryShowcaseProvider->provide($request->query->all()),
        ]);
    }
}
