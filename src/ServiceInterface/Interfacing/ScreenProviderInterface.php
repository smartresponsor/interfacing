<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing;

use App\Contract\View\ScreenSpecInterface;

interface ScreenProviderInterface
{
    /** @return list<ScreenSpecInterface> */
    public function provide(): array;
}
