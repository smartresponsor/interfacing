<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Interfacing\Security;

use App\Interfacing\Contract\View\ScreenSpecInterface;

/**
 * Screen-spec access resolver for action dispatch and screen-aware security checks.
 */
interface ScreenAccessResolverInterface
{
    public function isAllowed(ScreenSpecInterface $screen): bool;
}
