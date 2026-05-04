<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Access\RoleAccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Catalog\ScreenSpecCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\ShellNavProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ScreenController extends AbstractController
{
    public function __construct(
        private readonly ScreenSpecCatalogInterface $screenCatalog,
        private readonly ShellNavProviderInterface $navProvider,
        private readonly RoleAccessResolverInterface $accessResolver,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/catalog/screen/{screenId}', name: 'interfacing_catalog_screen_show', requirements: ['screenId' => '[a-z0-9][a-z0-9._-]{0,63}'], methods: ['GET'])]
    public function show(string $screenId): Response
    {
        $spec = $this->screenCatalog->get($screenId);
        if (!$this->accessResolver->canAccess($spec->requireRole())) {
            throw $this->createAccessDeniedException();
        }

        return $this->renderer->render('interfacing/shell/index.html.twig', [
            'title' => $spec->title(),
            'screenId' => $spec->id(),
            'navGroupList' => $this->navProvider->provide(),
            'activeScreenId' => $spec->id(),
            'activeViewId' => $spec->viewId(),
            'payload' => ['screen' => ['id' => $spec->id(), 'title' => $spec->title(), 'description' => $spec->description()]],
        ]);
    }
}
