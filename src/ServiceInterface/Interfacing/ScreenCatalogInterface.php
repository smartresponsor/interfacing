<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ScreenId;

interface ScreenCatalogInterface
{
    /** @return list<ScreenSpec> */
    public function all(): array;

    public function get(ScreenId $id): ScreenSpec;
}
