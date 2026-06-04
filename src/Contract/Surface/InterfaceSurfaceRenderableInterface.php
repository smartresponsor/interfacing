<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Surface;

interface InterfaceSurfaceRenderableInterface
{
    public function templateName(): string;

    /**
     * @return array<string, mixed>
     */
    public function toTemplateContext(): array;

    /**
     * @return array<string, mixed>
     */
    public function toFallbackData(): array;
}
