<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Http\Interfacing\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfacingShellController extends AbstractController
{
    #[Route(path: '/interfacing', name: 'interfacing_shell', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('interfacing/shell.html.twig');
    }
}
