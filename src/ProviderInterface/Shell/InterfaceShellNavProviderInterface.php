<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Shell;

use App\Interfacing\Contract\View\InterfaceShellNavGroupInterface;

interface InterfaceShellNavProviderInterface
{
    /** @return list<InterfaceShellNavGroupInterface> */
    public function provide(): array;
}
