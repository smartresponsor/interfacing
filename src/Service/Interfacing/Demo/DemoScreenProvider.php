<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Service\Interfacing\Demo;

use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutId;
use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenId;
use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenSpec;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Screen\ScreenProviderInterface;

final class DemoScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new ScreenSpec(new ScreenId('interfacing_doctor'), 'Interfacing Doctor', new LayoutId('interfacing_doctor_layout'), '/interfacing/doctor', 'tool'),
        ];
    }
}

