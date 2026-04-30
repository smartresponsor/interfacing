<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

interface ShellChromeProviderInterface
{
    /** @return array<string,mixed> */
    public function provide(?string $activeId = null): array;
}
