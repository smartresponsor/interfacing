<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing;

use App\Contract\View\ScreenSpecInterface;

interface ScreenCatalogInterface
{
    /** @return list<ScreenSpecInterface> */
    public function all(): array;

    public function get(string $id): ScreenSpecInterface;
}
