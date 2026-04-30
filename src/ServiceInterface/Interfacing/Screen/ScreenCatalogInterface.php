<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Interfacing\Screen;

use App\Interfacing\Contract\ValueObject\ScreenIdInterface;
use App\Interfacing\Contract\View\ScreenSpecInterface;

interface ScreenCatalogInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function all(): array;

    public function get(ScreenIdInterface $id): ScreenSpecInterface;
}
