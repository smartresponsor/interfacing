<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Access;

/**
 * Deprecated compatibility alias for request-aware screen/action access.
 *
 * New consumers must depend on ScreenActionAccessResolverInterface.
 */
interface AccessResolverInterface extends ScreenActionAccessResolverInterface
{
}
