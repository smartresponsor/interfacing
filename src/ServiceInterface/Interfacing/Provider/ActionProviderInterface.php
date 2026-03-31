<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Provider;

use App\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;

interface ActionProviderInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function provide(): array;
}
