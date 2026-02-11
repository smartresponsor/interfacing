<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Screen;

use App\DomainInterface\Interfacing\Layout\LayoutIdInterface;

/**
 *
 */

/**
 *
 */
interface ScreenSpecInterface
{
    /**
     * @return \App\DomainInterface\Interfacing\Screen\ScreenIdInterface
     */
    public function id(): ScreenIdInterface;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return \App\DomainInterface\Interfacing\Layout\LayoutIdInterface
     */
    public function layoutId(): LayoutIdInterface;

    /**
     * @return string
     */
    public function routePath(): string;

    /**
     * @return string
     */
    public function tag(): string;
}

