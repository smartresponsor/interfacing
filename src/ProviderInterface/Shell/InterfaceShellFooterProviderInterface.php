<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Shell;

use App\Interfacing\Contract\View\InterfaceShellFooterGroupInterface;

interface InterfaceShellFooterProviderInterface
{
    /** @return list<InterfaceShellFooterGroupInterface> */
    public function provide(): array;
}
