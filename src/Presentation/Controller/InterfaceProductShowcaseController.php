<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\Factory\Commerce\InterfaceProductSurfaceContractFactory;
use App\Interfacing\ProviderInterface\Commerce\InterfaceProductShowcaseProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceProductShowcaseController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceProductShowcaseProviderInterface $productShowcaseProvider,
        private InterfaceProductSurfaceContractFactory $surfaceContractFactory,
    ) {
    }

    #[Route('/interfacing/showcase/product', name: 'interfacing_product_storefront', methods: ['GET'], priority: 1300)]
    #[Route('/interfacing/showcase/product/alias', name: 'interfacing_product_storefront_no_slash', methods: ['GET'], priority: 1300)]
    #[Route('/interfacing/showcase/catalog/product', name: 'interfacing_catalog_product_showcase', methods: ['GET'], priority: 1200)]
    #[Route('/interfacing/showcase/catalog/product/alias', name: 'interfacing_catalog_product_showcase_no_slash', methods: ['GET'], priority: 1200)]
    public function index(Request $request): Response
    {
        $showcase = $this->productShowcaseProvider->provide($request->query->all());
        $surface = $this->surfaceContractFactory->create($showcase);

        return $this->renderer->renderSurface($surface);
    }
}
