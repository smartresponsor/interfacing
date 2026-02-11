<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Http\Interfacing\Controller;

use App\Domain\Interfacing\Value\ScreenId;
use App\ServiceInterface\Interfacing\AccessResolverInterface;
use App\ServiceInterface\Interfacing\ScreenCatalogInterface;
use App\ServiceInterface\Interfacing\ShellNavProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ScreenController extends AbstractController
{
    public function __construct(
        private ScreenCatalogInterface $screenCatalog,
        private ShellNavProviderInterface $navProvider,
        private AccessResolverInterface $accessResolver
    ) {}

    public function show(string $screenId): Response
    {
        $spec = $this->screenCatalog->get(ScreenId::of($screenId));
        if (!$this->accessResolver->canAccess($spec->accessRule())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('interfacing/shell/index.html.twig', [
            'navGroupList' => $this->navProvider->provide(),
            'activeScreenId' => $spec->id()->toString(),
            'activeViewId' => $spec->viewId(),
            'payload' => ['screen' => ['id' => $spec->id()->toString(), 'title' => $spec->title(), 'description' => $spec->description()]],
        ]);
    }
}
