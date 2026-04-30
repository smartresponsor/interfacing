<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Security;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\AccessResolverInterface;

final class AllowAllAccessResolver implements AccessResolverInterface
{
    public function isAllowed(ScreenSpecInterface $screen): bool
    {
        return true;
    }
}
