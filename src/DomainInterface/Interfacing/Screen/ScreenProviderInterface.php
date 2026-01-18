<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Screen;

use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenSpec;

interface ScreenProviderInterface
{
    /** @return ScreenSpec[] */
    public function provide(): array;
}
