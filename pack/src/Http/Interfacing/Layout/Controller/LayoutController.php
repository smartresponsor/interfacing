<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Http\Interfacing\Layout\Controller;

use SmartResponsor\Interfacing\HttpInterface\Interfacing\Layout\Controller\LayoutControllerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutGuardInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutShellInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class LayoutController extends AbstractController implements LayoutControllerInterface
{
    public function __construct(
        private readonly LayoutCatalogInterface $catalog,
        private readonly LayoutGuardInterface $guard,
        private readonly LayoutShellInterface $shell,
        private readonly InterfacingRuntimeInterface $runtime,
    ) {
    }

    public function home(Request $request): Response
    {
        return $this->screen($request, 'home');
    }

    public function screen(Request $request, string $slug): Response
    {
        $slug = trim($slug);
        if ($slug === '') {
            $slug = 'home';
        }

        if (!$this->catalog->hasSlug($slug)) {
            throw new NotFoundHttpException('Unknown screen slug.');
        }

        $layoutSpec = $this->catalog->getBySlug($slug);
        if (!$this->guard->canView($layoutSpec)) {
            throw new AccessDeniedHttpException('Access denied.');
        }

        $screenSpec = $this->runtime->resolveScreen($layoutSpec->getScreenId());
        $shell = $this->shell->build($layoutSpec);

        return $this->render('interfacing/layout/shell.html.twig', [
            'shell' => $shell,
            'layoutSpec' => $layoutSpec,
            'screenSpec' => $screenSpec,
            'context' => $layoutSpec->getContext(),
        ]);
    }
}
