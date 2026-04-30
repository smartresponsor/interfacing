<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutGuardInterface;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutShellInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LayoutController extends AbstractController
{
    public function __construct(
        private readonly LayoutCatalogInterface $catalog,
        private readonly LayoutGuardInterface $guard,
        private readonly LayoutShellInterface $shell,
        private readonly InterfacingRuntimeInterface $runtime,
    ) {
    }

    public function show(Request $request, string $slug = 'home'): Response
    {
        $spec = $this->catalog->findBySlug($slug);
        if (null === $spec) {
            throw $this->createNotFoundException('Unknown layout slug.');
        }

        if (!$this->guard->canView($spec, $this($this->container->has('security.token_storage') ? $this->container->get('security.token_storage')->getToken() : null))) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        $componentName = $this->runtime->resolveScreenComponentName($spec->screenId());

        return $this->render('interfacing/layout/shell.html.twig', [
            'layout' => $this->shell->build($spec, $this->catalog->list()),
            'screenComponent' => $componentName,
            'screenContext' => $spec->context(),
        ]);
    }
}
