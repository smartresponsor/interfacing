<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Security;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\ScreenAccessResolverInterface;

/**
 * Standalone fallback resolver for screen-spec access checks.
 */
class AllowAllScreenAccessResolver implements ScreenAccessResolverInterface
{
    public function isAllowed(ScreenSpecInterface $screen): bool
    {
        return true;
    }
}
