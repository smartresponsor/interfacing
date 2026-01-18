<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Screen;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Screen\ScreenIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

interface ScreenCatalogInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function all(): array;

    public function get(ScreenIdInterface $id): ScreenSpecInterface;
}

