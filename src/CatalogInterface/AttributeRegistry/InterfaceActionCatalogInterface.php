<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\CatalogInterface\AttributeRegistry;

interface InterfaceActionCatalogInterface
{
    /**
     * @return list<InterfaceActionEndpointInterface>
     */
    public function allForScreen(string $screenId): array;

    /**
     * @return \App\Interfacing\EndpointInterface\AttributeRegistry\InterfaceActionEndpointInterface
     */
    public function get(string $screenId, string $actionId): InterfaceActionEndpointInterface;
}
