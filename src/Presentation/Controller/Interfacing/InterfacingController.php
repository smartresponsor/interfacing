<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\Controller\Interfacing;

use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
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
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('interfacing/page/index.html.twig');
    }

    #[Route('/interfacing/{id}', name: 'interfacing_screen', methods: ['GET'])]
    public function screen(string $id): Response
    {
        $spec = $this->layout->find($id);
        if (null === $spec) {
            throw $this->createNotFoundException('Unknown interfacing screen: '.$id);
        }

        $cap = $spec->capability();
        if (null !== $cap && !$this->access->allow($cap, ['layoutId' => $spec->id(), 'screenId' => $spec->screenId()->toString()])) {
            throw $this->createAccessDeniedException('Access denied for screen: '.$id);
        }

        $component = $this->screen->componentName($spec->screenId());
        $context = $this->context->contextFor($spec);

        return $this->render('interfacing/page/screen.html.twig', [
            'spec' => $spec,
            'component' => $component,
            'context' => $context,
            'title' => $spec->title(),
        ]);
    }
}
