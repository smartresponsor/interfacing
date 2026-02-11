<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Infra\Interfacing\Provider;

use App\Domain\Interfacing\Layout\LayoutSpec;
use App\DomainInterface\Interfacing\Layout\LayoutProviderInterface;

/**
 *
 */

/**
 *
 */
final class DemoLayoutProvider implements LayoutProviderInterface
{
    /**
     * @return \App\Domain\Interfacing\Layout\LayoutSpec[]
     */
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
