<?php

declare(strict_types=1);

namespace App\Presentation\Controller\Interfacing;

use App\ServiceInterface\Interfacing\AccessResolverInterface;
use App\ServiceInterface\Interfacing\ScreenCatalogInterface;
use App\ServiceInterface\Interfacing\ShellNavProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ScreenController extends AbstractController
{
    public function __construct(
        private readonly ScreenCatalogInterface $screenCatalog,
        private readonly ShellNavProviderInterface $navProvider,
        private readonly AccessResolverInterface $accessResolver,
    ) {
    }

    public function show(string $screenId): Response
    {
        $spec = $this->screenCatalog->get($screenId);
        if (!$this->accessResolver->canAccess($spec->requireRole())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('interfacing/shell/index.html.twig', [
            'navGroupList' => $this->navProvider->provide(),
            'activeScreenId' => $spec->id(),
            'activeViewId' => $spec->viewId(),
            'payload' => ['screen' => ['id' => $spec->id(), 'title' => $spec->title(), 'description' => $spec->description()]],
        ]);
    }
}
