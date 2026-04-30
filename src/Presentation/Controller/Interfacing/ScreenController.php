<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\AccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\ScreenCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\ShellNavProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ScreenController extends AbstractController
{
    public function __construct(
        private readonly ScreenCatalogInterface $screenCatalog,
        private readonly ShellNavProviderInterface $navProvider,
        private readonly AccessResolverInterface $accessResolver,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

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
