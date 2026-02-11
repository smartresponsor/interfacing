<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Model\AccessRule;

/**
 *
 */

/**
 *
 */
interface AccessResolverInterface
{
    /**
     * @param \App\Domain\Interfacing\Model\AccessRule $rule
     * @return bool
     */
    public function canAccess(AccessRule $rule): bool;
}
