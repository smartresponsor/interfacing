<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Layout;

/**
 *
 */

/**
 *
 */
interface LayoutSpecInterface
{
    /**
     * @return \App\DomainInterface\Interfacing\Layout\LayoutIdInterface
     */
    public function id(): LayoutIdInterface;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function twigPath(): string;
}

