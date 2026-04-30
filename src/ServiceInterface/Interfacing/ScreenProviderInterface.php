<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\Contract\View\ScreenSpecInterface;

interface ScreenProviderInterface
{
    /** @return list<ScreenSpecInterface> */
    public function provide(): array;
}
