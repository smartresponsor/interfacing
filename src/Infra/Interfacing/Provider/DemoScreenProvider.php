<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Infra\Interfacing\Provider;

use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenId;
use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenSpec;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Screen\ScreenProviderInterface;

final class DemoScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new ScreenSpec(
                new ScreenId('interfacing-doctor'),
                'Interfacing Doctor',
                'interfacing-doctor-layout',
                []
            ),
        ];
    }
}
