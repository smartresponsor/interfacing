<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\BuilderInterface\View\InterfaceScreenViewBuilderInterface;
use App\Interfacing\Contract\Error\InterfaceScreenForbidden;
use App\Interfacing\Contract\Error\InterfaceScreenNotFound;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Dynamic Interfacing screen route owner.
 *
 * Static workspace pages remain owned by InterfaceController. This controller
 * owns runtime screen rendering and maps screen-domain errors to Symfony HTTP
 * exceptions at the presentation boundary.
 */
final readonly class InterfaceDynamicScreenController
{
    public function __construct(
        private InterfaceScreenViewBuilderInterface $screenViewBuilder,
        private InterfaceRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/{id}', name: 'interfacing_screen', methods: ['GET'])]
    public function show(string $id): Response
    {
        try {
            $context = $this->screenViewBuilder->build($id);
        } catch (InterfaceScreenNotFound $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        } catch (InterfaceScreenForbidden $exception) {
            throw new AccessDeniedHttpException($exception->getMessage(), $exception);
        }

        return $this->renderer->render('page/screen.html.twig', $context + [
            'screenId' => $id,
        ]);
    }
}
