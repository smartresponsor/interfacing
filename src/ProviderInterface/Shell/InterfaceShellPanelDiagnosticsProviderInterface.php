<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Shell;

interface InterfaceShellPanelDiagnosticsProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function report(?string $activeId = null): array;
}
