<?php

declare(strict_types=1);

namespace App\Interfacing\ResolverInterface\Access;

/**
 * Legacy screen-spec role resolver used by older InterfaceScreenController flows.
 */
interface InterfaceRoleAccessResolverInterface
{
    /** @param array<int, string> $requireRole */
    public function canAccess(array $requireRole): bool;
}
