<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Action;

interface InterfaceActionProviderInterface
{
    /** @return array<int, InterfaceActionEndpointInterface> */
    public function provide(): array;
}
