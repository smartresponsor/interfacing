<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenSpec;

interface ScreenProviderInterface
{
    /** @return list<ScreenSpec> */
    public function provide(): array;
}
