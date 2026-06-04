<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Resolver\Security;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;
use App\Interfacing\ResolverInterface\Security\InterfaceScreenAccessResolverInterface;

/**
 * Standalone fallback resolver for screen-spec access checks.
 */
class InterfaceAllowAllScreenAccessResolver implements InterfaceScreenAccessResolverInterface
{
    public function isAllowed(InterfaceScreenSpecInterface $screen): bool
    {
        return true;
    }
}
