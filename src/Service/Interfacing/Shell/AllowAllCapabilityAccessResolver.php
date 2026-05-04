<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\ServiceInterface\Interfacing\Shell\CapabilityAccessResolverInterface;

/**
 * Standalone fallback resolver for shell capability checks.
 */
class AllowAllCapabilityAccessResolver implements CapabilityAccessResolverInterface
{
    public function allow(string $capability, array $context = []): bool
    {
        return true;
    }
}
