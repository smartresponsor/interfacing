<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Http\Interfacing\Health\Controller;

use SmartResponsor\Interfacing\HttpInterface\Interfacing\Health\Controller\InterfacingHealthControllerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class InterfacingHealthController implements InterfacingHealthControllerInterface
{
    public function __construct(
        private readonly ScreenRegistryInterface $screenRegistry,
        private readonly LayoutCatalogInterface $layoutCatalog,
        private readonly string $kernelEnvironment,
    ) {
    }

    public function health(): Response
    {
        $payload = [
            'ok' => true,
            'time' => (new \DateTimeImmutable('now'))->format(DATE_ATOM),
            'env' => $this->kernelEnvironment,
            'screenCount' => count($this->screenRegistry->all()),
            'layoutCount' => count($this->layoutCatalog->all()),
        ];

        return new JsonResponse($payload, Response::HTTP_OK);
    }
}
