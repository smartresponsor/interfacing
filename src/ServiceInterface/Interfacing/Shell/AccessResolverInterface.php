<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Shell;

/**
 *
 */

/**
 *
 */
interface AccessResolverInterface
{
    /**
     * @param array<string,mixed> $context
     */
    public function allow(string $capability, array $context = []): bool;
}
