<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Rendering;

use App\Interfacing\Contract\Template\InterfaceTemplateRenderableInterface;
use Symfony\Component\HttpFoundation\Response;

interface InterfaceRendererInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function render(string $template, array $context = [], int $status = 200): Response;

    public function renderTemplate(InterfaceTemplateRenderableInterface $templateContract, array $context = [], int $status = 200): Response;
}
