<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\Controller\Interfacing;

use App\Contract\Error\ScreenForbidden;
use App\Contract\Error\ScreenNotFound;
use App\ServiceInterface\Interfacing\View\InterfacingIndexViewBuilderInterface;
use App\ServiceInterface\Interfacing\View\ScreenViewBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfacingController extends AbstractController
{
    public function __construct(
        private readonly InterfacingIndexViewBuilderInterface $indexBuilder,
        private readonly ScreenViewBuilderInterface $screenBuilder,
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('interfacing/page/index.html.twig', $this->indexBuilder->build());
    }

    #[Route('/interfacing/{id}', name: 'interfacing_screen', methods: ['GET'])]
    public function screen(string $id): Response
    {
        try {
            return $this->render('interfacing/page/screen.html.twig', $this->screenBuilder->build($id));
        } catch (ScreenNotFound $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        } catch (ScreenForbidden $e) {
            throw $this->createAccessDeniedException($e->getMessage(), $e);
        }
    }
}
