<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Provider;

use App\Domain\Interfacing\Model\AccessRule;
use App\Domain\Interfacing\Model\ScreenSpec;
use App\Domain\Interfacing\Value\ScreenId;
use App\ServiceInterface\Interfacing\ScreenProviderInterface;

/**
 *
 */

/**
 *
 */
final class DoctorScreenProvider implements ScreenProviderInterface
{
    /**
     * @return \App\Domain\Interfacing\Model\ScreenSpec[]
     */
    public function provide(): array
    {
        return [
            new ScreenSpec(
                ScreenId::of('interfacing-doctor'),
                'Interfacing Doctor',
                'Inspect screens and actions.',
                'interfacing/doctor/index',
                AccessRule::requireRole(['ROLE_ADMIN'])
            ),
        ];
    }
}
