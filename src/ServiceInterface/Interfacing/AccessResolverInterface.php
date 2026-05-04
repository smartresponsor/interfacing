<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Access\RoleAccessResolverInterface;

/**
 * Deprecated compatibility alias for the legacy role-based screen resolver.
 *
 * New consumers must depend on Access\RoleAccessResolverInterface.
 */
interface AccessResolverInterface extends RoleAccessResolverInterface
{
}
