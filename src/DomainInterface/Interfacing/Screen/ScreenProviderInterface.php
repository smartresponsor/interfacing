<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\DomainInterface\Interfacing\Screen;

use App\Domain\Interfacing\Screen\ScreenSpec;

/**
 *
 */

/**
 *
 */
interface ScreenProviderInterface
{
    /** @return ScreenSpec[] */
    public function provide(): array;
}
