<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Demo;

use App\Interfacing\Contract\ValueObject\LayoutSlot;
use App\Interfacing\Contract\View\LayoutBlockSpec;
use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class DemoLayoutProvider implements LayoutProviderInterface
{
    public function provide(): array
    {
        return [
            new LayoutScreenSpec(
                block: [
                    new LayoutBlockSpec(
                        'twig',
                        LayoutSlot::MAIN,
                        [
                            'twigPath' => 'interfacing/doctor/page.html.twig',
                            'contextKey' => 'doctor',
                        ],
                    ),
                ],
                id: 'interfacing_doctor_layout',
                title: 'Doctor layout',
                navGroup: 'tool',
                routePath: 'interfacing/doctor/page',
            ),
        ];
    }
}
