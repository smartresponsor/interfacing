<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface;

use App\Interfacing\EndpointInterface\AttributeRegistry\InterfaceActionEndpointInterface;

interface InterfaceActionProviderInterface
{
    /** @return array<int, InterfaceActionEndpointInterface> */
    public function provide(): array;
}
