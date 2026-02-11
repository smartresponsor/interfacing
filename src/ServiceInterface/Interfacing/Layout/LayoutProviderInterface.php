<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Interfacing\Layout;

use App\DomainInterface\Interfacing\Layout\LayoutSpecInterface;

/**
 *
 */

/**
 *
 */
interface LayoutProviderInterface
{
    /** @return array<int, LayoutSpecInterface> */
    public function provide(): array;
}

