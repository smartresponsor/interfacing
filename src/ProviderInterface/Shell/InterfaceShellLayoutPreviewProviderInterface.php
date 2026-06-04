<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Shell;

interface InterfaceShellLayoutPreviewProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function preview(?string $activeId = null): array;
}
