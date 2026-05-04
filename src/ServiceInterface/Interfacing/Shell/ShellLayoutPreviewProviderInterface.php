<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

interface ShellLayoutPreviewProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function preview(?string $activeId = null): array;
}
