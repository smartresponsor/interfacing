<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Screen;

use App\DomainInterface\Interfacing\Layout\LayoutIdInterface;

interface ScreenSpecInterface
{
    public function id(): ScreenIdInterface;
    public function title(): string;
    public function layoutId(): LayoutIdInterface;
    public function routePath(): string;
    public function tag(): string;
}

