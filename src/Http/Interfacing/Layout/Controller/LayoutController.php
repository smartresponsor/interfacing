<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Http\Interfacing\Layout\Controller;

use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutGuardInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutShellInterface;
use App\ServiceInterface\Interfacing\Runtime\InterfacingRuntimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LayoutController extends AbstractController implements LayoutControllerInterface
{
    public function __construct(
        private LayoutCatalogInterface $catalog,
        private LayoutGuardInterface $guard,
        private LayoutShellInterface $shell,
        private InterfacingRuntimeInterface $runtime,
    ) {
    }

    public function show(Request $request, string $slug = 'home'): Response
    {
        $spec = $this->catalog->findBySlug($slug);
        if ($spec === null) {
            throw $this->createNotFoundException('Unknown layout slug.');
        }

        if (!$this->guard->canView($spec, $this->container->get('security.token_storage')->getToken())) {
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
