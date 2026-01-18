<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Screen;

use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenId;
use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenSpec;

interface ScreenRegistryInterface
{
    /** @return array<string, ScreenSpec> */
    public function all(): array;

    public function get(ScreenId $screenId): ScreenSpec;
}
