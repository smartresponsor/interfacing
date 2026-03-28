<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Interfacing\Layout;

use App\Contract\View\LayoutScreenSpecInterface;

interface LayoutProviderInterface
{
    /** @return array<int, LayoutScreenSpecInterface> */
    public function provide(): array;
}
