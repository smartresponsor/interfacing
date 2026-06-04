<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\CatalogInterface\AttributeRegistry;

interface InterfaceScreenCatalogInterface
{
    /**
     * @return list<InterfaceScreenDescriptorInterface>
     */
    public function all(): array;

    /**
     * @return \App\Interfacing\DescriptorInterface\AttributeRegistry\InterfaceScreenDescriptorInterface
     */
    public function get(string $screenId): InterfaceScreenDescriptorInterface;
}
