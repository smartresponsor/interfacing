<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Resolver\Shell;

use App\Interfacing\ResolverInterface\Shell\InterfaceCapabilityAccessResolverInterface;

/**
 * Standalone fallback resolver for shell capability checks.
 */
class InterfaceAllowAllCapabilityAccessResolver implements InterfaceCapabilityAccessResolverInterface
{
    public function allow(string $capability, array $context = []): bool
    {
        return true;
    }
}
