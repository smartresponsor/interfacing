<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ProviderInterface;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;

interface InterfaceScreenProviderInterface
{
    /** @return array<int, InterfaceScreenSpecInterface> */
    public function provide(): array;
}
