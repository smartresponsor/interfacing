<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Http\Interfacing\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

/**
 *
 */

/**
 *
 */
final readonly class ShellController
{
    /**
     * @param \Twig\Environment $twig
     */
    public function __construct(private Environment $twig) {}

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    #[Route(path: '/interfacing', name: 'interfacing_shell', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $screenId = (string)$request->query->get('screen', 'interfacing-doctor');
        $html = $this->twig->render('interfacing/shell.html.twig', [
            'screenId' => $screenId,
        ]);
        return new Response($html);
    }
}
