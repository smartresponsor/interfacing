<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Service\Interfacing\Demo;

use App\Integration\Symfony\Attribute\AsInterfacingScreen;
use App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface;

#[AsInterfacingScreen(
    id: 'interfacing.doctor',
    title: 'Interfacing Doctor',
    navGroup: 'Interfacing',
    navOrder: 1,
)]
final class DemoDoctorScreenDescriptor implements ScreenDescriptorInterface
{
    public function screenId(): string
    {
        return 'interfacing.doctor';
    }

    public function title(): string
    {
        return 'Interfacing Doctor';
    }

    public function navGroup(): ?string
    {
        return 'Interfacing';
    }

    public function navOrder(): int
    {
        return 1;
    }

    public function isVisible(): bool
    {
        return true;
    }
}
