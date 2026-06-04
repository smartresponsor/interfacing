<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Demo;

use App\Interfacing\Contract\View\InterfaceLayoutBlockSpec;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\Contract\View\InterfaceScreenSpec;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;

final class InterfaceDemoScreenProvider implements InterfaceScreenProviderInterface
{
    public function provide(): array
    {
        $layout = new InterfaceLayoutScreenSpec(
            block: [
                new InterfaceLayoutBlockSpec('twig', 'main', [
                    'twigPath' => 'doctor/page.html.twig',
                    'contextKey' => 'doctor',
                ]),
            ],
            id: 'interfacing_doctor_layout',
            title: 'Doctor layout',
            navGroup: 'tool',
            routePath: 'doctor/page',
        );

        return [
            new InterfaceScreenSpec('interfacing_doctor', 'Interfacing Doctor', $layout, [
                'doctor' => ['status' => 'ok'],
            ]),
        ];
    }
}
