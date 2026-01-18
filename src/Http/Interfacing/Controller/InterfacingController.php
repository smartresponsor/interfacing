<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Http\Interfacing\Controller;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class InterfacingController extends AbstractController implements \SmartResponsor\Interfacing\HttpInterface\Interfacing\Controller\InterfacingControllerInterface
{
    public function __construct(
        private LayoutCatalogInterface $layout,
        private ScreenRegistryInterface $screen,
        private ScreenContextAssemblerInterface $context,
        private AccessResolverInterface $access,
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
        if ($spec === null) {
            throw $this->createNotFoundException('Unknown interfacing screen: '.$id);
        }

        $cap = $spec->capability();
        if ($cap !== null && !$this->access->allow($cap, ['layoutId' => $spec->id(), 'screenId' => $spec->screenId()->toString()])) {
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
