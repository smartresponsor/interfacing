<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Infra\Interfacing\Provider;

use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutSpec;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Layout\LayoutProviderInterface;

final class DemoLayoutProvider implements LayoutProviderInterface
{
    public function provide(): array
    {
        return [
            new LayoutSpec(
                'interfacing-doctor-layout',
                'Interfacing Doctor',
                [
                    ['type' => 'link', 'label' => 'Doctor UI', 'href' => '/interfacing/doctor'],
                ]
            ),
        ];
    }
}
