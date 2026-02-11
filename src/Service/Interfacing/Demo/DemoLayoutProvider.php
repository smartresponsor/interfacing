<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Demo;

use App\Domain\Interfacing\Layout\LayoutId;
use App\Domain\Interfacing\Layout\LayoutSpec;
use App\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

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
            new LayoutSpec(new LayoutId('interfacing_doctor_layout'), 'Doctor layout', 'interfacing/doctor/page.html.twig'),
        ];
    }
}

