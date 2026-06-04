<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ProviderInterface\Layout;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;

interface InterfaceLayoutProviderInterface
{
    /** @return array<int, InterfaceLayoutScreenSpecInterface> */
    public function provide(): array;
}
