<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing;

use App\Contract\View\ShellNavGroupInterface;

interface ShellNavProviderInterface
{
    /** @return list<ShellNavGroupInterface> */
    public function provide(): array;
}
