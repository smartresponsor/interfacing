<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class ShellController
{
    public function __construct(private InterfacingRendererInterface $renderer)
    {
    }

    #[Route('/interfacing/shell-legacy', name: 'interfacing_shell_legacy', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $screenId = (string) $request->query->get('screen', 'interfacing-doctor');

        return $this->renderer->render('interfacing/shell.html.twig', [
            'title' => 'Legacy shell',
            'screenId' => $screenId,
        ]);
    }
}
