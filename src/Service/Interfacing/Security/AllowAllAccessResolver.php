<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Security;

use App\Interfacing\ServiceInterface\Interfacing\Security\AccessResolverInterface;

/**
 * Deprecated compatibility class for screen-spec allow-all access checks.
 *
 * New services should use AllowAllScreenAccessResolver.
 */
final class AllowAllAccessResolver extends AllowAllScreenAccessResolver implements AccessResolverInterface
{
}
