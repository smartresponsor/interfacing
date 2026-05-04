<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

interface ShellNavigationMapProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function map(?string $activeId = null): array;
}
