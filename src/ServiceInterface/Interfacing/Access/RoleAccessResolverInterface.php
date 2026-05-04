<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Access;

/**
 * Legacy screen-spec role resolver used by older ScreenController flows.
 */
interface RoleAccessResolverInterface
{
    /** @param array<int, string> $requireRole */
    public function canAccess(array $requireRole): bool;
}
