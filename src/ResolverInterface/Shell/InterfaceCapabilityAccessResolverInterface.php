<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ResolverInterface\Shell;

/**
 * Shell chrome capability resolver for navigation, layout, and panel visibility.
 */
interface InterfaceCapabilityAccessResolverInterface
{
    /**
     * @param array<string,mixed> $context
     */
    public function allow(string $capability, array $context = []): bool;
}
