<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\Service\Interfacing\Access\SymfonyRoleAccessResolver;
use App\Interfacing\ServiceInterface\Interfacing\AccessResolverInterface;

/**
 * Deprecated compatibility class for legacy role-list access checks.
 *
 * New services should use Access\SymfonyRoleAccessResolver.
 */
final class SymfonyAccessResolver extends SymfonyRoleAccessResolver implements AccessResolverInterface
{
}
