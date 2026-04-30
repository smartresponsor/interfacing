<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Presentation;

use Symfony\Component\HttpFoundation\Response;

interface InterfacingRendererInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function render(string $template, array $context = [], int $status = 200): Response;
}
