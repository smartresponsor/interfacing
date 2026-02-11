<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Infra\Interfacing\Provider;

use App\Domain\Interfacing\Screen\ScreenId;
use App\Domain\Interfacing\Screen\ScreenSpec;
use App\DomainInterface\Interfacing\Screen\ScreenProviderInterface;

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
