<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Access;

use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenSpec;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Access\AccessResolverInterface;

final class AllowAllAccessResolver implements AccessResolverInterface
{
    public function isGranted(ScreenSpec $screenSpec, array $baseContext): bool
    {
        return true;
    }
}
