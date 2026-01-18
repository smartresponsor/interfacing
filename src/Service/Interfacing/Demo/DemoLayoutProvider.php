<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Service\Interfacing\Demo;

use SmartResponsor\Domain\Interfacing\Layout\LayoutId;
use SmartResponsor\Domain\Interfacing\Layout\LayoutSpec;
use SmartResponsor\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class DemoLayoutProvider implements LayoutProviderInterface
{
    public function provide(): array
    {
        return [
            new LayoutSpec(new LayoutId('interfacing_doctor_layout'), 'Doctor layout', 'interfacing/doctor/page.html.twig'),
        ];
    }
}

