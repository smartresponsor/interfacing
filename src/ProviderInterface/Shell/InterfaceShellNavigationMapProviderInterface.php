<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Shell;

interface InterfaceShellNavigationMapProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function map(?string $activeId = null): array;
}
