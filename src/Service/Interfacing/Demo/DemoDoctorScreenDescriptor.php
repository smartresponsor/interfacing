<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Service\Interfacing\Demo;

    use App\Domain\Interfacing\Attribute\AsInterfacingScreen;
use App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface;

    /**
     *
     */

    /**
     *
     */
    #[AsInterfacingScreen(
    id: 'interfacing.doctor',
    title: 'Interfacing Doctor',
    navGroup: 'Interfacing',
    navOrder: 1,
)]
final class DemoDoctorScreenDescriptor implements ScreenDescriptorInterface
{
    /**
     * @return string
     */
    public function screenId(): string
    {
        return 'interfacing.doctor';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Interfacing Doctor';
    }

    /**
     * @return string|null
     */
    public function navGroup(): ?string
    {
        return 'Interfacing';
    }

    /**
     * @return int
     */
    public function navOrder(): int
    {
        return 1;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return true;
    }
}

