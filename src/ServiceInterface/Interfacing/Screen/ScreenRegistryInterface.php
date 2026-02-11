<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\ServiceInterface\Interfacing\Screen;

use App\Domain\Interfacing\Screen\ScreenId;
use App\Domain\Interfacing\Screen\ScreenSpec;

/**
 *
 */

/**
 *
 */
interface ScreenRegistryInterface
{
    /** @return array<string, ScreenSpec> */
    public function all(): array;

    /**
     * @param \App\Domain\Interfacing\Screen\ScreenId $screenId
     * @return \App\Domain\Interfacing\Screen\ScreenSpec
     */
    public function get(ScreenId $screenId): ScreenSpec;
}
