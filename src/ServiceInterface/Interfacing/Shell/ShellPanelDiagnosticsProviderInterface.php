<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

interface ShellPanelDiagnosticsProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function report(?string $activeId = null): array;
}
