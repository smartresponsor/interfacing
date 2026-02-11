<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Access;

use App\Domain\Interfacing\Screen\ScreenSpec;
use App\DomainInterface\Interfacing\Access\AccessResolverInterface;

final class AllowAllAccessResolver implements AccessResolverInterface
{
    public function isGranted(ScreenSpec $screenSpec, array $baseContext): bool
    {
        return true;
    }
}
