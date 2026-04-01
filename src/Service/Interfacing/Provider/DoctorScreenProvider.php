<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Provider;

use App\Contract\View\LayoutScreenSpec;
use App\Contract\View\ScreenSpec;
use App\ServiceInterface\Interfacing\ScreenProviderInterface;

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
