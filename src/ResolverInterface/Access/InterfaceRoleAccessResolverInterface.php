<?php

declare(strict_types=1);

namespace App\Interfacing\ResolverInterface\Access;

/**
 * Screen-spec role resolver used by InterfaceScreenController flows.
 */
interface InterfaceRoleAccessResolverInterface
{
    /** @param array<int, string> $requireRole */
    public function canAccess(array $requireRole): bool;
}
