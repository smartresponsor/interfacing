<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Action;

use App\Interfacing\Contract\ValueObject\ActionIdInterface;

interface ActionCatalogInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function all(): array;

    public function has(ActionIdInterface $id): bool;

    public function get(ActionIdInterface $id): ActionEndpointInterface;
}
