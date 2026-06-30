<?php

declare(strict_types=1);

namespace App\Interfacing\Contract;

interface InterfaceSurfaceRenderableInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toTemplateContext(): array;

    /**
     * @return array<string, mixed>
     */
    public function toFallbackData(): array;

    public function templateName(): string;
}
