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

/**
 *
 */

/**
 *
 */
final class ScreenController extends AbstractController
{
    /**
     * @param \App\ServiceInterface\Interfacing\ScreenCatalogInterface $screenCatalog
     * @param \App\ServiceInterface\Interfacing\ShellNavProviderInterface $navProvider
     * @param \App\ServiceInterface\Interfacing\AccessResolverInterface $accessResolver
     */
    public function __construct(
        private readonly ScreenCatalogInterface    $screenCatalog,
        private readonly ShellNavProviderInterface $navProvider,
        private readonly AccessResolverInterface   $accessResolver
    ) {}

    /**
     * @param string $screenId
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
