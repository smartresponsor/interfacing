<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Layout;

use App\Contract\View\LayoutScreenSpec;

interface LayoutShellInterface
{
    /**
     * @return array<string,mixed>
     */
    public function build(LayoutScreenSpec $activeSpec, array $allSpec): array;
}
