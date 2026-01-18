<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Service\Interfacing\Demo;

use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutId;
use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutSpec;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class DemoLayoutProvider implements LayoutProviderInterface
{
    public function provide(): array
    {
        return [
            new LayoutSpec(new LayoutId('interfacing_doctor_layout'), 'Doctor layout', 'interfacing/doctor/page.html.twig'),
        ];
    }
}

