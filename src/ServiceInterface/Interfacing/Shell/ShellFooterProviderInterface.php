<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

use App\Interfacing\Contract\View\ShellFooterGroupInterface;

interface ShellFooterProviderInterface
{
    /** @return list<ShellFooterGroupInterface> */
    public function provide(): array;
}
