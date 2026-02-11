<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Model\ScreenSpec;

/**
 *
 */

/**
 *
 */
interface ScreenProviderInterface
{
    /** @return list<ScreenSpec> */
    public function provide(): array;
}
