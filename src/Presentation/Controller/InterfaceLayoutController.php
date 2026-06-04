<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\CatalogInterface\Layout\InterfaceLayoutCatalogInterface;
use App\Interfacing\GuardInterface\Layout\InterfaceLayoutGuardInterface;
use App\Interfacing\ServiceInterface\Layout\InterfaceLayoutShellInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use App\Interfacing\ServiceInterface\Runtime\InterfaceRuntimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InterfaceLayoutController extends AbstractController
{
    public function __construct(
        private readonly InterfaceLayoutCatalogInterface $catalog,
        private readonly InterfaceLayoutGuardInterface $guard,
        private readonly InterfaceLayoutShellInterface $shell,
        private readonly InterfaceRuntimeInterface $runtime,
        private readonly InterfaceRendererInterface $renderer,
    ) {
    }

    public function show(Request $request, string $slug = 'home'): Response
    {
        $spec = $this->catalog->findBySlug($slug);
        if (null === $spec) {
            throw $this->createNotFoundException('Unknown layout slug.');
        }

        if (!$this->guard->canView($spec, $this->container->has('security.token_storage') ? $this->container->get('security.token_storage')->getToken() : null)) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        $componentName = $this->runtime->resolveScreenComponentName($spec->screenId());

        return $this->renderer->render('layout/shell.html.twig', [
            'title' => $spec->title(),
            'screenId' => $spec->id(),
            'layout' => $this->shell->build($spec, $this->catalog->list()),
            'screenComponent' => $componentName,
            'screenContext' => $spec->context(),
        ]);
    }
}
