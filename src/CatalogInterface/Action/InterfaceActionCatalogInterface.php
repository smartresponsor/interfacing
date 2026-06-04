<?php

declare(strict_types=1);

namespace App\Interfacing\CatalogInterface\Action;

use App\Interfacing\Contract\ValueObject\InterfaceActionIdInterface;

interface InterfaceActionCatalogInterface
{
    /** @return array<int, InterfaceActionEndpointInterface> */
    public function all(): array;

    public function has(InterfaceActionIdInterface $id): bool;

    public function get(InterfaceActionIdInterface $id): InterfaceActionEndpointInterface;
}
