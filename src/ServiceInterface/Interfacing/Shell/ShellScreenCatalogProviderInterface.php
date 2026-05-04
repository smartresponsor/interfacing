<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

interface ShellScreenCatalogProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function catalog(?string $activeId = null): array;
}
