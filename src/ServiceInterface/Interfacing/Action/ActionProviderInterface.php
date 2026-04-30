<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Action;

interface ActionProviderInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function provide(): array;
}
