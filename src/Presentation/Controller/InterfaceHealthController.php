<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class InterfaceHealthController extends AbstractController
{
    public function show(Request $request): JsonResponse
    {
        return new JsonResponse([
            'ok' => true,
            'service' => 'interfacing',
            'ts' => (new \DateTimeImmutable('now'))->format(DATE_ATOM),
        ]);
    }
}
