<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\Contract\View\ShellNavGroupInterface;

interface ShellNavProviderInterface
{
    /** @return list<ShellNavGroupInterface> */
    public function provide(): array;
}
