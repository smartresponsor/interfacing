<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Provider;

use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;

interface ActionProviderInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function provide(): array;
}
