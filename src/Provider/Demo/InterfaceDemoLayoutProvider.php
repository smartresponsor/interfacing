<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Demo;

use App\Interfacing\Contract\ValueObject\InterfaceLayoutSlot;
use App\Interfacing\Contract\View\InterfaceLayoutBlockSpec;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\ProviderInterface\Layout\InterfaceLayoutProviderInterface;

final class InterfaceDemoLayoutProvider implements InterfaceLayoutProviderInterface
{
    public function provide(): array
    {
        return [
            new InterfaceLayoutScreenSpec(
                block: [
                    new InterfaceLayoutBlockSpec(
                        'twig',
                        InterfaceLayoutSlot::MAIN,
                        [
                            'twigPath' => 'doctor/page.html.twig',
                            'contextKey' => 'doctor',
                        ],
                    ),
                ],
                id: 'interfacing_doctor_layout',
                title: 'Doctor layout',
                navGroup: 'tool',
                routePath: 'doctor/page',
            ),
        ];
    }
}
