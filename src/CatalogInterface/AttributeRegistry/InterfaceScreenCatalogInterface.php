<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\CatalogInterface\AttributeRegistry;

use App\Interfacing\DescriptorInterface\AttributeRegistry\InterfaceScreenDescriptorInterface;

interface InterfaceScreenCatalogInterface
{
    /**
     * @return list<InterfaceScreenDescriptorInterface>
     */
    public function all(): array;

    public function get(string $screenId): InterfaceScreenDescriptorInterface;
}
