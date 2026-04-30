<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\Contract\View\ScreenSpecInterface;

interface ScreenCatalogInterface
{
    /** @return list<ScreenSpecInterface> */
    public function all(): array;

    public function get(string $id): ScreenSpecInterface;
}
