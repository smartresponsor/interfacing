<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\RegistryInterface\Action;

use App\Interfacing\EndpointInterface\Action\InterfaceActionEndpointInterface;

interface InterfaceActionRegistryInterface
{
    public function has(string $screenId, string $actionId): bool;

    /** @return array<int, array{actionId:string, title:string}> */
    public function listForScreen(string $screenId): array;

    public function resolve(string $screenId, string $actionId): InterfaceActionEndpointInterface;
}
