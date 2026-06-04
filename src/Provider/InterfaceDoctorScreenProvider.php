<?php

declare(strict_types=1);

namespace App\Interfacing\Provider;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\Contract\View\InterfaceScreenSpec;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;

final class InterfaceDoctorScreenProvider implements InterfaceScreenProviderInterface
{
    public function provide(): array
    {
        return [
            new InterfaceScreenSpec(
                'interfacing-doctor',
                'Interfacing Doctor',
                new InterfaceLayoutScreenSpec(id: 'interfacing-doctor-layout', title: 'Interfacing Doctor', routePath: 'doctor/index'),
                [],
                ['ROLE_ADMIN'],
                'Inspect screens and actions.',
                'doctor/index',
            ),
        ];
    }
}
