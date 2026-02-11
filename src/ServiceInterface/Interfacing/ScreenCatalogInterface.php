<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Model\ScreenSpec;
use App\Domain\Interfacing\Value\ScreenId;

/**
 *
 */

/**
 *
 */
interface ScreenCatalogInterface
{
    /** @return list<ScreenSpec> */
    public function all(): array;

    /**
     * @param \App\Domain\Interfacing\Value\ScreenId $id
     * @return \App\Domain\Interfacing\Model\ScreenSpec
     */
    public function get(ScreenId $id): ScreenSpec;
}
