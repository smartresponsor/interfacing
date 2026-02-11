<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Demo;

use App\Domain\Interfacing\Layout\LayoutId;
use App\Domain\Interfacing\Screen\ScreenId;
use App\Domain\Interfacing\Screen\ScreenSpec;
use App\ServiceInterface\Interfacing\Screen\ScreenProviderInterface;

/**
 *
 */

/**
 *
 */
final class DemoScreenProvider implements ScreenProviderInterface
{
    /**
     * @return \App\Domain\Interfacing\Screen\ScreenSpec[]
     */
    public function provide(): array
    {
        return [
            new ScreenSpec(new ScreenId('interfacing_doctor'), 'Interfacing Doctor', new LayoutId('interfacing_doctor_layout'), '/interfacing/doctor', 'tool'),
        ];
    }
}

