<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Interfacing\Registry;

use App\Contract\View\ScreenSpecInterface;

interface ScreenRegistryInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function all(): array;

    public function has(string $screenId): bool;

    public function get(string $screenId): ScreenSpecInterface;
}
