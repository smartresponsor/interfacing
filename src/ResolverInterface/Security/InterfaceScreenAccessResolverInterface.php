<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ResolverInterface\Security;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;

/**
 * Screen-spec access resolver for action dispatch and screen-aware security checks.
 */
interface InterfaceScreenAccessResolverInterface
{
    public function isAllowed(InterfaceScreenSpecInterface $screen): bool;
}
