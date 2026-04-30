<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Provider;

use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\Contract\View\ScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;

final class DoctorScreenProvider implements ScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new ScreenSpec(
                'interfacing-doctor',
                'Interfacing Doctor',
                new LayoutScreenSpec(id: 'interfacing-doctor-layout', title: 'Interfacing Doctor', routePath: 'interfacing/doctor/index'),
                [],
                ['ROLE_ADMIN'],
                'Inspect screens and actions.',
                'interfacing/doctor/index',
            ),
        ];
    }
}
