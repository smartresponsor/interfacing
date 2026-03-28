<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Demo;

use App\Contract\View\LayoutBlockSpec;
use App\Contract\View\LayoutScreenSpec;
use App\Contract\View\ScreenSpec;
use App\ServiceInterface\Interfacing\Screen\ScreenProviderInterface;

final class DemoScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        $layout = new LayoutScreenSpec(
            block: [
                new LayoutBlockSpec('twig', 'main', [
                    'twigPath' => 'interfacing/doctor/page.html.twig',
                    'contextKey' => 'doctor',
                ]),
            ],
            id: 'interfacing_doctor_layout',
            title: 'Doctor layout',
            navGroup: 'tool',
            routePath: 'interfacing/doctor/page',
        );

        return [
            new ScreenSpec('interfacing_doctor', 'Interfacing Doctor', $layout, [
                'doctor' => ['status' => 'ok'],
            ]),
        ];
    }
}
