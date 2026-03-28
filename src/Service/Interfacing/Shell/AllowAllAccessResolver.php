<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Service\Interfacing\Shell;

use App\ServiceInterface\Interfacing\Shell\AccessResolverInterface;

/**
 *
 */

/**
 *
 */
final class AllowAllAccessResolver implements AccessResolverInterface
{
    /**
     * @param string $capability
     * @param array $context
     * @return bool
     */
    public function allow(string $capability, array $context = []): bool
    {
        return true;
    }
}
