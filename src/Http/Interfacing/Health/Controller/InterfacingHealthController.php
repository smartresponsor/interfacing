<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Http\Interfacing\Health\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */

/**
 *
 */
final class InterfacingHealthController extends AbstractController implements InterfacingHealthControllerInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        return new JsonResponse([
            'ok' => true,
            'service' => 'interfacing',
            'ts' => (new \DateTimeImmutable('now'))->format(DATE_ATOM),
        ]);
    }
}
