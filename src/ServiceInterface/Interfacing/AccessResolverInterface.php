<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

interface AccessResolverInterface
{
    /** @param array<int, string> $requireRole */
    public function canAccess(array $requireRole): bool;
}
