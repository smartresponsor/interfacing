<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Access;

use App\Interfacing\ServiceInterface\Interfacing\Access\AccessResolverInterface;

/**
 * Deprecated compatibility class for request-aware screen/action access.
 *
 * New services should use SymfonyScreenActionAccessResolver.
 */
final class SymfonyAccessResolver extends SymfonyScreenActionAccessResolver implements AccessResolverInterface
{
}
