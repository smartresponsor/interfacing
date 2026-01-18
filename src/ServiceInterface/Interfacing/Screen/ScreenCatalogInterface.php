<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\ServiceInterface\Interfacing\Screen;

use SmartResponsor\DomainInterface\Interfacing\Screen\ScreenIdInterface;
use SmartResponsor\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

interface ScreenCatalogInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function all(): array;

    public function get(ScreenIdInterface $id): ScreenSpecInterface;
}

