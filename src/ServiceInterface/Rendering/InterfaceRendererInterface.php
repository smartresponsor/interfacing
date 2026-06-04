<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Rendering;

use Symfony\Component\HttpFoundation\Response;

interface InterfaceRendererInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function render(string $template, array $context = [], int $status = 200): Response;

    public function renderSurface(InterfaceSurfaceRenderableInterface $surface, array $context = [], int $status = 200): Response;
}
