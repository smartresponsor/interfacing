<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\GenericCrudWorkbenchViewBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Generic CRUD workbench bridge for known Smart Responsor resources.
 *
 * This controller intentionally does not own business persistence. It gives the
 * shell a real route-compatible index/new/show/edit/delete surface while the
 * owning components progressively publish their concrete handlers.
 */
final readonly class GenericCrudWorkbenchController
{
    public function __construct(
        private GenericCrudWorkbenchViewBuilderInterface $viewBuilder,
        private InterfacingRendererInterface $renderer,
    ) {
    }

    public function show(Request $request): Response
    {
        return $this->renderer->render(
            'interfacing/order/summary.html.twig',
            $this->viewBuilder->build($request),
        );
    }
}
