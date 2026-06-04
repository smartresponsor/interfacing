<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\RegistryInterface\AttributeRegistry;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;

interface InterfaceScreenRegistryInterface
{
    /** @return array<int, InterfaceScreenSpecInterface> */
    public function all(): array;

    public function has(string $screenId): bool;

    public function get(string $screenId): InterfaceScreenSpecInterface;
}
