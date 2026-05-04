<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Interfacing\Security;

/**
 * Deprecated compatibility alias for screen-spec access checks.
 *
 * New consumers must depend on ScreenAccessResolverInterface.
 */
interface AccessResolverInterface extends ScreenAccessResolverInterface
{
}
