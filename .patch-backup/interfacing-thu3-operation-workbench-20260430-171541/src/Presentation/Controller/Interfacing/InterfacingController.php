<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfacingController extends AbstractController
{
    public function __construct(
        private readonly LayoutCatalogInterface $layout,
        private readonly ScreenRegistryInterface $screen,
        private readonly ScreenContextAssemblerInterface $context,
        private readonly AccessResolverInterface $access,
        private readonly InterfacingRendererInterface $renderer,
        private readonly EcommerceScreenCatalogProviderInterface $ecommerceScreenCatalogProvider,
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('interfacing/page/index.html.twig', [
            'title' => 'Interfacing workspace',
            'screenId' => 'interfacing.index',
            'ecommerceScreenMatrix' => $this->ecommerceScreenCatalogProvider->provide(),
            'ecommerceScreenGroups' => $this->ecommerceScreenCatalogProvider->groupedByZone(),
            'ecommerceScreenStatusCounts' => $this->ecommerceScreenCatalogProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/screens', name: 'interfacing_screen_directory', methods: ['GET'])]
    public function screenDirectory(): Response
    {
        return $this->renderer->render('interfacing/page/screen_directory.html.twig', [
            'title' => 'Interfacing screen directory',
            'screenId' => 'screen.directory',
            'ecommerceScreenMatrix' => $this->ecommerceScreenCatalogProvider->provide(),
            'ecommerceScreenGroups' => $this->ecommerceScreenCatalogProvider->groupedByZone(),
            'ecommerceScreenStatusCounts' => $this->ecommerceScreenCatalogProvider->statusCounts(),
            'ecommerceComponentGroups' => $this->ecommerceScreenCatalogProvider->componentSummaryByZone(),
        ]);
    }

    #[Route('/interfacing/{id}', name: 'interfacing_screen', methods: ['GET'])]
    #[Route('/interfacing/screen/{id}', name: 'interfacing_screen_legacy', methods: ['GET'])]
    public function screen(string $id): Response
    {
        $spec = $this->layout->find($id);
        if (null === $spec) {
            throw $this->createNotFoundException('Unknown interfacing screen: '.$id);
        }

        $cap = $spec->guardKey();
        if (null !== $cap && !$this->access->allow($cap, ['layoutId' => $spec->id(), 'screenId' => $spec->screenId()->toString()])) {
            throw $this->createAccessDeniedException('Access denied for screen: '.$id);
        }

        $component = $this->screen->componentName($spec->screenId());
        $context = $this->context->contextFor($spec);

        return $this->renderer->render('interfacing/page/screen.html.twig', [
            'spec' => $spec,
            'component' => $component,
            'context' => $context,
            'title' => $spec->title(),
            'screenId' => $spec->id(),
        ]);
    }
}
