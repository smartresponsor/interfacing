<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

/**
 * Deprecated compatibility alias for shell capability checks.
 *
 * New consumers must depend on CapabilityAccessResolverInterface.
 */
interface AccessResolverInterface extends CapabilityAccessResolverInterface
{
}
