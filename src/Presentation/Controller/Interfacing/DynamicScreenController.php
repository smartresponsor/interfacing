<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\Contract\Error\ScreenForbidden;
use App\Interfacing\Contract\Error\ScreenNotFound;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\ScreenViewBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Dynamic Interfacing screen route owner.
 *
 * Static workspace pages remain owned by InterfacingController. This controller
 * owns runtime screen rendering and maps screen-domain errors to Symfony HTTP
 * exceptions at the presentation boundary.
 */
final readonly class DynamicScreenController
{
    public function __construct(
        private ScreenViewBuilderInterface $screenViewBuilder,
        private InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/{id}', name: 'interfacing_screen', methods: ['GET'])]
    #[Route('/interfacing/screen/{id}', name: 'interfacing_screen_legacy', methods: ['GET'])]
    public function show(string $id): Response
    {
        try {
            $context = $this->screenViewBuilder->build($id);
        } catch (ScreenNotFound $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        } catch (ScreenForbidden $exception) {
            throw new AccessDeniedHttpException($exception->getMessage(), $exception);
        }

        return $this->renderer->render('interfacing/page/screen.html.twig', $context + [
            'screenId' => $id,
        ]);
    }
}
