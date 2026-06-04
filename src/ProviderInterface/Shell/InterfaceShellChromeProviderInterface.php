<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Shell;

interface InterfaceShellChromeProviderInterface
{
    /** @return array<string,mixed> */
    public function provide(?string $activeId = null): array;
}
